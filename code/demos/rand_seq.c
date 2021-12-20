#include <stdlib.h>
#include <stdio.h>
#include <time.h>

int main()
{
	printf("Random Sequence:\n");

	srand(1640017452);
	for (int i = 0; i < 10; i++)
	{
		printf("%d\n", rand());
	}
}

/*

Random Sequence computed at 11:24 AM on 12/20/21:
1900284898
990923183
1482506163
1848104483
1341182726
1236410492
539989718
460881894
1852850802
1096260505

*/