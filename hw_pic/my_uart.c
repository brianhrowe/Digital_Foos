#include "maindefs.h"
#include <usart.h>
#include "my_uart.h"

static uart_comm *uc_ptr;
int length = 0;
unsigned char Txdata[16];
unsigned char last = 0x00;
void uart_recv_int_handler()
{
	int iter;
	unsigned char input;
	int done = -1;
	if (DataRdyUSART()) 
	{
		input = ReadUSART();
		if(input == 0x0A && last == 0x0D)
		{
				done = 1;	
		}		
		uc_ptr->buffer[uc_ptr->buflen] = input;
		//Txdata[uc_ptr->buflen] = input;
		uc_ptr->buflen++;
//		// check if a message should be sent
		if (uc_ptr->buflen > 10 || done > 0  ) 
		{
			ToMainLow_sendmsg(uc_ptr->buflen,MSGT_UART_DATA,(void *) uc_ptr->buffer);
			for(iter = 0; iter < uc_ptr->buflen; iter++)
			{
					Txdata[iter] = uc_ptr->buffer[iter];
			}
			uc_ptr->buflen = 0;	
			done  = -1;
		}
		last = input;
//	}
//	if (USART_Status.OVERRUN_ERROR == 1) {
//		// we've overrun the USART and must reset
//		// send an error message for this
//		RCSTAbits.CREN = 0;
//		RCSTAbits.CREN = 1;
//		ToMainLow_sendmsg(0,MSGT_OVERRUN,(void *) 0);
//	}
	}	
}

void init_uart_recv(uart_comm *uc)
{	uc_ptr = uc;
	uc_ptr->buflen = 0;
}

void init_xbee()
{
//	printf("Init_Xbee)");
}