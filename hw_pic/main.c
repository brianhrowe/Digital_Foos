/* Compile options:  -ml (Large code model) */
#include "maindefs.h"
#include <stdio.h>
#include <stdlib.h>
#include <usart.h>
#include <timers.h>
#include "interrupts.h"
#include "messages.h"
#include "my_uart.h"
#include "uart_thread.h"
#include "timer1_thread.h"
#include "timer0_thread.h"
#include <p18cxxx.h>
#include <string.h>
#include <adc.h>
#include <delays.h>

#define RETRY_ATTEMPTS 5

//////////
//CMD Mode
//////////
#define CMD_STRING "$$$" 												//3
#define EXIT_STRING "exit\r"											//5

/////////////////////////
//Score Black manual POST
/////////////////////////
#define POST_1 "POST /prototype/score.php HTTP/1.1\r\n"					//36
#define POST_2 "Host: 192.168.1.105\r\n"								//21
#define POST_3 "User-Agent: PIC/DigitalFoos\r\n"						//29
#define POST_4 "Content-Type: application/x-www-form-urlencoded\r\n"	//49
#define POST_5 "Content-Length: 16\r\n\r\n"								//22
#define POST_6_BLACK "goal=true&team=b"									//16
#define POST_6_YELLOW "goal=true&team=y"								//16
//////////////////////////
//Score Yellow manual POST
//////////////////////////
#define SET_PASSPHRASE "set w p thatsABitchMoveSanta\r" 				//29
#define SET_SSID "set w s Boondocks\r"									//18
#define SET_CHANNEL "set w c 0\r"										//10
#define SET_AUTH "set w a 4\r"											//10
#define SET_JOIN "set w j 1\r"											//10
#define SET_DHCP "set i d 1\r"											//10

/////////////////////
//Set to auto connect
/////////////////////
#define SET_IP_HOST_IP "set i h 192.168.1.105\r"						//22
	//or
#define SET_IP_HOST_DNS "set i h 0\r"									//10
#define SET_DNS_Name "set d n www.domain.com\r"							//23
	//and
#define SET_IP_PROTO "set i p 18\r"										//11
#define SET_IP_REMOTE "set i r 80\r"									//11
//set to auto send begin of url
#define SET_COM_REMOTE_KV "set c r GET$/prototype/score.php?goal=true&team=\r"	//51
//set up unique identifier
#define SET_OPTP_DEVICEID "set o d ksq_tornado_sport_0001\r"	//31
#define SET_OPTP_FORMAT_ID "set o f 8\r"	//10
//set to auto connect and forward uart data
#define SET_UART_MODE "set u m 2\r"									//10

#define EMPTY "\r\n"

/////////////////
//Get Information
/////////////////
#define SHOW_CONNECTION "show c\r"										//7
#define GET_WLAN_STRING "get w\r"										//6
#define GET_EVERYTHING "get e\r"										//6

//////////////
//Config Stuff
//////////////
#define SAVE "save\r"													//5
#define REBOOT "reboot\r"												//7
#define FACTORY_RESET "factory RESET\r"									//14

/////////////
//Network CMDS
//////////////
#define JOIN_BOONDOCKS "join Boondocks\r"								//15
#define OPEN_CONNECTION "open 192.168.1.105 80\r"						//22

////////////
//Clear Comm
////////////
#define SET_COMM_OPEN "set c o 0\r"										//10
#define SET_COMM_REMOTE "set c r 0\r"									//10

#pragma config WDT = OFF

///////////////////////
//Function Declarations
///////////////////////
void initialize();
void longDelay();
int rebootModule();
int enterCommandMode();
int exitCommandMode();
int joinNetwork();
int openConnection();
int factoryReset();
void autoConnect();
void sendGoalBlack();
void sendGoalYellow();
void sendString(rom char* data, int length);

unsigned char string[MSGLEN];
int inCommandMode = -1;
// This program 
// 1) Polls A/D conversions from 2 Proximity 
void main (void){
	unsigned int result;
	uart_comm uc;
	uart_thread_struct	uthread_data; // info for uart_lthread
	timer1_thread_struct t1thread_data; // info for timer1_lthread
	timer0_thread_struct t0thread_data; // info for timer0_lthread

	// set to run really, really fast...
	OSCCON = 0x6C; // 4 MHz
	OSCTUNEbits.PLLEN = 1; // 4x the clock speed in the previous line

	// initialize my uart recv handling code
	init_uart_recv(&uc);

	// init the timer1 lthread
	init_timer1_lthread(&t1thread_data);

	TRISAbits.TRISA0 = 1;  //AN0 equals input
 	TRISCbits.TRISC7 = 0;//1;  //Rx equals input
  	TRISCbits.TRISC6 = 0;  //TX equals output
  	TRISCbits.TRISC3 = 0;  //cl equals output
  	TRISCbits.TRISC4 = 0;  //DA equals output
	//initialize all output pins to 0
	LATCbits.LATC6 = 0;
	LATCbits.LATC3 = 0;
	LATCbits.LATC4 = 0;
	//Set PortB(leds) for output
 	TRISB = 0;
  	PORTB = 0;
	// set direction for PORTB to output
	LATB = 0;

	// initialize ADC
	OpenADC(	/*config*/ ADC_FOSC_RC & ADC_RIGHT_JUST & ADC_20_TAD,
			/*config2*/ ADC_CH1 &  ADC_REF_VDD_VSS  & ADC_INT_OFF,
			/*portconfig*/ ADC_4ANA );

	// set up PORTA for input
	/*
	PORTA = 0x0;	// clear the port
	LATA = 0x0;		// clear the output latch
	//ADCON1 = 0x0F;	// turn off the A2D function on these pins
	// Only for 40-pin version of this chip CMCON = 0x07;	// turn the comparator off
	//TRISA = 0x0F;	// set RA3-RA0 to inputs
	*/

	// initialize Timers
	OpenTimer0( TIMER_INT_ON & T0_8BIT & T0_SOURCE_INT & T0_PS_1_128);
	OpenTimer1( TIMER_INT_ON & T1_PS_1_1 & T1_16BIT_RW & T1_SOURCE_INT & T1_OSC1EN_OFF & T1_SYNC_EXT_OFF);
	
	// Peripheral interrupts can have their priority set to high or low
	// enable high-priority interrupts and low-priority interrupts
	enable_interrupts();

	// Decide on the priority of the enabled peripheral interrupts
	// 0 is low, 1 is high
	// Timer1 interrupt
	IPR1bits.TMR1IP = 0;
	// USART RX interrupt
	IPR1bits.RCIP = 0;
	// I2C interrupt
	IPR1bits.SSPIP = 1;

	// configure the hardware USART device
  	OpenUSART( USART_TX_INT_OFF & USART_RX_INT_ON & USART_ASYNCH_MODE & USART_EIGHT_BIT   & 
		USART_CONT_RX & USART_BRGH_LOW, 0x19);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//My Stuff		/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	result = factoryReset();
//	initialize();	
//	result = joinNetwork();
//	result = openConnection();
//	sendGoalBlack();
	while(1)
	{
		LATBbits.LATB0 = 1;
		Delay10KTCYx(0);
		Delay10KTCYx(0);
		LATBbits.LATB0 = 0;
		Delay10KTCYx(0);
	}

	CloseADC();
}

void initialize()		///Works with current delays
{
	int result;
	result = enterCommandMode();
	sendString(GET_WLAN_STRING, 6);
	Delay10KTCYx(0);
	sendString(SET_SSID, 18);
	Delay10KTCYx(0);
	sendString(SET_PASSPHRASE, 29);
	Delay10KTCYx(0);
	sendString(SET_CHANNEL, 10);
	Delay10KTCYx(0);
	sendString(SET_AUTH, 10);
	Delay10KTCYx(0);
	sendString(SET_JOIN, 10);
	Delay10KTCYx(0);	
	sendString(SET_DHCP, 10);
	Delay10KTCYx(0);
	sendString(SET_COMM_OPEN, 10);
	Delay10KTCYx(0); 
	sendString(SET_COMM_REMOTE, 10);
	Delay10KTCYx(0);
	autoConnect();
	sendString(SAVE, 5);
	Delay10KTCYx(0);
	result = rebootModule();
	longDelay();
}

void longDelay()		///Works
{
	Delay10KTCYx(0);	
	Delay10KTCYx(0);
	Delay10KTCYx(0);
	Delay10KTCYx(0);
	Delay10KTCYx(0);
	Delay10KTCYx(0);
}		

void sendString(rom char* data, int length)		///Works
{
	int i;
	unsigned char temp;
	Delay10KTCYx(100);
	while(BusyUSART());
	for(i = 0; i < length; i++)
	{
		temp = data[i];
		putcUSART(temp);
		Delay100TCYx(100);
	}	
}

int rebootModule()		///Works
{
	int retries;
	int offset;
	int result;
	if(inCommandMode == -1)
	{
		result = enterCommandMode();
		if(result == -1)
			return -1;
		else
		inCommandMode = 1;
	}
	for(retries = 0; retries < RETRY_ATTEMPTS; retries++)
	{
		sendString(REBOOT, 8);	
		longDelay();
		if(Txdata[0] != NULL)
		{
			if(Txdata[0] == '*' && Txdata[1] == 'R' && Txdata[2] == 'E')
			{
				inCommandMode = -1;
				return 1;
			}		
		}
	}	
	return -1;
}	

int enterCommandMode(){ 		///Works
	int retries;
	int offset;
	if(inCommandMode == 1){
		return 1;
	}	
	for(retries = 0; retries < RETRY_ATTEMPTS; retries++){
		sendString(CMD_STRING, 3);
		Delay10KTCYx(100);	
		//longDelay();
		if(Txdata[0] != NULL){
			if(Txdata[0] == 'C' && Txdata[1] == 'M' && Txdata[2] == 'D'){
				inCommandMode = 1;
				return 1;
			}		
		}
	}
	return -1;	
	inCommandMode = -1;
}	

int exitCommandMode(){		///Works
	int retries;
	int offset;
	if(inCommandMode == -1){
		return 1;
	}	
	for(retries = 0; retries < RETRY_ATTEMPTS; retries++){
		sendString(EXIT_STRING, 5);
		Delay10KTCYx(100);
		if(Txdata[0] != NULL){
			if(Txdata[0] == 'E' && Txdata[1] == 'X' && Txdata[2] == 'I' && Txdata[3] == 'T'){
				inCommandMode = -1;
				return 1;
			}		
		}
	}
	return -1;	
}	
  
int joinNetwork(){			///More Testing
	int retries;
	int offset;
	int result;
	if(inCommandMode == -1){
		result = enterCommandMode();
		if(result == -1)
			return -1;
		else
		inCommandMode = 1;
	}
	for(retries = 0; retries < RETRY_ATTEMPTS; retries++){
		sendString(JOIN_BOONDOCKS, 15);
		longDelay();
		sendString(SHOW_CONNECTION, 7);
		longDelay();		
		if(Txdata[0] != NULL){
			if(Txdata[2] == '3'){
				result = exitCommandMode();
				while(result != 1){
					result = exitCommandMode();
				}	
				return 1;
			}		
		}
	}
	result = exitCommandMode();
	return -1;
}	

int openConnection(){		//Working
	int retries;
	int offset;
	int result;
//	if(inCommandMode == -1)
//	{
//		result = enterCommandMode();
//		if(result == -1)
//			return -1;
//		else
//		inCommandMode = 1;
//	}
//	for(retries = 0; retries < RETRY_ATTEMPTS; retries++)
//	{
		sendString(CMD_STRING, 3);
		inCommandMode = 1;
		sendString(OPEN_CONNECTION, 22);
		//Delay10KTCYx(100);
	//	if(Txdata[0] != NULL)
	//	{
	//		if(Txdata[0] == '<' && Txdata[1] == '2' && Txdata[2] == '.' && Txdata[3] == '2' && Txdata[4] == '7' && Txdata[5] == '>' &Txdata[6] == ' ' && Txdata[7] == '*' && Txdata[8] == 'O' && Txdata[9] == 'P' && Txdata[10] == 'E')
	//		{
			//	sendString(CMD_STRING, 3);
			//	sendString(SHOW_CONNECTION, 7);
			//	longDelay();
			//	if(Txdata[3] == '1')
			//	{
			//		result = exitCommandMode();
			//		return 1;
			//	}
	//		}		
	//	}
//	}
//	result = exitCommandMode();
//	return -1;
}	

void autoConnect(){
	int result;
	//Set to auto connect
	sendString(SET_IP_HOST_IP, 22);
	//or
	//#define SET_IP_HOST_DNS "set i h 0\r"									//10
	//#define SET_DNS_Name "set d n www.domain.com\r"							//23
	//and
	sendString(SET_IP_PROTO, 11);
	sendString(SET_IP_REMOTE, 11);
	//set to auto send begin of url
	sendString(SET_COM_REMOTE_KV, 49);
	//set to auto connect and forward uart data
	sendString(SET_UART_MODE, 10);
	sendString(SET_OPTP_DEVICEID, 31);
	sendString(SET_OPTP_FORMAT_ID, 10);
	//sendString(EXIT_STRING, 5);
	//Delay10KTCYx(200); 
	//Delay10KTCYx(200); 
	//Delay10KTCYx(200); 
}

void sendGoalBlack()
{
	sendString("b", 1);
}
void sendGoalYellow()
{
	sendString("y", 1);
}

int factoryReset()
{
	int result;
	result = enterCommandMode();
	sendString(FACTORY_RESET, 14);
}