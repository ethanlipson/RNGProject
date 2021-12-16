#!/usr/bin/env python3
#feel free to rename this file, lcgcracker sounds lame :(

from math import gcd
import sys


#I'm using standard input to read numbers,
#but we could add functionality for arguments.
def main():
	# givens=[]
	# for line in sys.stdin:
	# 	givens.append(int(line))

	givens = [1865, 7648, 825, 2582]
	
	solve_lcg(givens)


def solve_lcg(givens):
	eqs = [[m, n] for n, m in zip(givens, givens[1:])]
	subtracted = [[eq[0] - eqs[0][0], eq[1] - eqs[0][1]] for eq in eqs[1:]]
	lhs = subtracted[0][0] * abs(subtracted[1][1]) + subtracted[0][1] * subtracted[1][0]
	lhs = abs(lhs)
	print(lhs)
	
	possible_moduli = []
	for factor in get_all_factors(lhs):
		if factor < 7649:
			continue
		if factor >= 10000:
			continue
		possible_moduli.append(factor)
	
	print(possible_moduli)
		
		
			


def sign(x):
	if x > 0: return 1
	if x < 0: return -1
	return 0


def get_prime_factors(n):
	out = []
	while n % 2 == 0:
		n //= 2
		out.append(2)
	f = 3
	while f * f <= n:
		if n % f == 0:
			out.append(f)
			n //= f
		else:
			f += 2
	if n != 1:
		out.append(n)
	return out


#cool trick I came up with to calculate all factors quickly.
#doing it the brute force way took like 5 seconds for big numbers.
#numbers are not in order.
def get_all_factors(n):
	prime = get_prime_factors(n)
	count = len(prime)
	out = set()
	for i in range(0,2**count):
		factor = 1
		for j in range(0, count):
			factor *= prime[j] if (i>>j)%2 else 1
		out.add(factor)
	return out


def lcm(*args: int) -> int:
	product = reduce(lambda a, b: a * b, args)
	return product // gcd**(len(args) - 1)


if __name__ == '__main__':
	main()

