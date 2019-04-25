#include"iostream"

using namespace std;

 void func1(int *,int);

 int main( )

{   int i,V[5]={1,2,3,2,7};

                int *ptrV = V;

                for(i=0;i<=4;i++)

               cout<<*(V+i)<<" ";

                if (i==5)

                               cout<<endl<<"nuevo arreglo"<<endl;

                func1(ptrV,4);

               for(i=0;i<5;i++){

                               cout<<*ptrV<<endl;

                               ptrV++;                }             

                ptrV--;

                cout<<endl<<endl;

                cout<<V<<"\t"<<&V[4]<<"\t"<<*V<<"\n";

                cout<<ptrV<<"\t"<<*ptrV<<"\t"<<&ptrV<<"\n";

   return 0;

}

void func1(int *b,int n)

{   int i;

   for(i=0;i<=n;i++)

       if(b[i] == 2)

       { b=b+1;

         *(b+i)=b[i]*2;

       }

}