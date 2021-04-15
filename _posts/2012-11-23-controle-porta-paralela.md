---
title: Simples controle de porta paralela em C
layout: post
---

O script desenvolvido utiliza das funções de bit a bit do C para
deslocar o 1 de um byte composto inicialmente por 10000000 para o lado.

No segundo momento seria: 01000000, depois: 00100000 e assim
sucessivamente.

Na saída pode-se colocar um conjunto de LED's, de modo que estes, de uma
forma linear, pisquem.


# O código:

```
 #include  
 #include sys/io.h;

 unsigned int Saida;

 nt openPort(void);
 void controlerPort(void);
 void closePort(void);


 void main (void)
 {
     openPort();
     controlerPort();      
     closePort();
 }

 int openPort(void)
 {

     // 0x378 é o endereço padrão da primeira porta paralela para pc's

     // io perm pede permissão para o sistema operacional para obter o

     // controle sobre a porta
     if(!ioperm(0X378,3,1)) return 0;
 }


 void closePort(void)
 {

    //zera a saída antes de fechar
     outb(0, 0x378);
     ioperm(0x378,3,0); //passa-se 0 no ultimo parametro para se fechar
a porta
 }

 void controlerPort(void)
 {
     int i,a;
     for(a = 0; a <= 10 ; a++)
     {
         Saida = 1;

         for(i = 0; i <= 7; i++)
         {
             outb(Saida, 0x378); // imprime saída na porta
             printf("%d\n", Saida);
             Saida = Saida >> 1; // desloca o bit para a direita
             sleep(1); //para por 1 segundo
         }
     }
 }

```

Para funcionar talvez seja necessário habilitar o funcionamento da porta
através da BIOS do seu
 computador.
