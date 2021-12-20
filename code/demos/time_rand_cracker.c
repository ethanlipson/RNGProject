#include <stdlib.h>
#include <stdio.h>
#include <time.h>

int matches(int time, int *ref, int n);

int main()
{

	int expected[] = {
		1900284898,
		990923183,
		1482506163,
		1848104483,
		1341182726,
		1236410492,
		539989718,
		460881894,
		1852850802,
		1096260505,
	};

	int expected_length = 10;

	int start_time = time(NULL);
	while (!matches(start_time, expected, expected_length) && start_time > 0)
	{
		start_time--;
	}
	printf("%d\n", start_time);
}

#define TRUE 1
#define FALSE 0

int matches(int time, int *ref, int n)
{
	srand(time);
	for (int i = 0; i < n; i++)
	{
		if (rand() != ref[i])
			return FALSE;
	}
	return TRUE;
}
