// This is where the "user" interrupts handlers should go
// The *must* be declared in "user_interrupts.h"

#include "maindefs.h"
#include <timers.h>
#include "user_interrupts.h"
#include "messages.h"
#include <p18cxxx.h>
#include <adc.h>
#include <delays.h>


int result;
int res = 1;
int res1 = 1;
int counter = 0;
int counter2 = 0;

// A function called by the interrupt handler
// Polls the IR proximity sensors for goals and call function to send goal when one is sensed.
void timer0_int_handler(){
	unsigned int val;
	int	length, msgtype;

///////////////////////////////
//////Sensor #1 - Black Team///
///////////////////////////////
		//Set ADC Channel to Sensor #1
		SetChanADC(ADC_CH2);
		// Delay for 50TCY
		Delay10TCYx( 50 );     
		// Start conversion
  		ConvertADC();         
		// Wait for completion
		while( BusyADC() );
		// Delay for 50TCY   
		Delay10TCYx( 5 );     
		// Read result
  		res = ReadADC();   
		if ((res > 0x1D0)){
			counter2++;
			//light 1st led
			if(counter2 > 5 && counter2 < 100){
				LATBbits.LATB1 = 1;
				sendGoalBlack();
				counter2 = 101;
			}
		}
		else{
			LATBbits.LATB1 = 0;
			counter2 = 0;
		}
/////////////////////////////
////Sensor #1 - Yellow Team///
/////////////////////////////
		//Set ADC Channel to Sensor #1
		SetChanADC(ADC_CH0);
		// Delay for 50TCY
		Delay10TCYx( 5 );     
		// Start conversion
  		ConvertADC();         
		// Wait for completion
		while( BusyADC() );
		// Delay for 50TCY   
		Delay10TCYx( 5 );     
		// Read result
		res1 = 0;
  		res1 = ReadADC();   
		if ((res1 > 0x1D0)){
			//debouncing counter/filter
			counter++;
			if(counter > 5 && counter < 100){
				LATBbits.LATB2 = 1;
				sendGoalYellow();
				//make counter > 100 so it won't send a ton of goals
				counter = 101;
			}
		}
		else{
			LATBbits.LATB2 = 0;
			//Reset counter
			counter = 0;
		}
	// reset the timer
	WriteTimer0(0);
}


// A function called by the interrupt handler
// This one does the action I wanted for this program on a timer1 interrupt
void timer1_int_handler()
{
	unsigned int result;
	// read the timer and then send an empty message to main()
	result = ReadTimer1();
	ToMainLow_sendmsg(0,MSGT_TIMER1,(void *) 0);
	// reset the timer
	WriteTimer1(0);
}
