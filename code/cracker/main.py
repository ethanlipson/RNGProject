#!/usr/bin/env python3
#feel free to rename this file, lcgcracker sounds lame :(

from functools import reduce
from math import gcd
import sys


#I'm using standard input to read numbers,
#but we could add functionality for arguments.
def main():
	# givens=[]
	# for line in sys.stdin:
	# 	givens.append(int(line))

	givens = list(map(int, open('nums').read().split(' ')))

	solve_lcg(givens)


def solve_lcg(givens):
	greatest_possible_modulus = guess_modulus(givens)

	# The modulus could be greatest_possible_modulus or any of its factors
	for modulus in sorted(get_all_factors(greatest_possible_modulus), reverse=True):
		print(f'Testing: {modulus}')
		multiplier = guess_multiplier(givens, modulus)
		increment = guess_increment(givens, modulus, multiplier)

		if givens[1] == (givens[0] * multiplier + increment) % modulus:
			print(f'{modulus = }')
			print(f'{multiplier = }')
			print(f'{increment = }')
			break


def guess_modulus(nums: 'list[int]') -> int:
	# Subtract each equation from the previous to eliminate constant terms
	differences = []
	for i in range(0, len(nums) - 1):
		differences.append(nums[i+1] - nums[i])

	# Rearrange equations to be congruent to 0 (mod n)
	zeroes = []
	for i in range(0, len(nums) - 3):
		zeroes.append(differences[i + 2] * differences[i] - differences[i + 1] * differences[i + 1])

	# Find the GCD of these zeroes
	# The result is likely to be our modulus, or if not, a multiple of it
	# The chance that it's exactly our modulus increases with the number of givens
	return reduce(gcd, zeroes)


def guess_multiplier(givens: 'list[int]', modulus: int) -> int:
	# We need to solve a modular linear equation of the form:
	# ax = b (mod n)

	# We can solve by multiplying both sides
	# by the modular inverse of a (mod n),
	# calculated using the Extended Euclidean Algorithm

	a = (givens[1] - givens[0]) % modulus
	b = (givens[2] - givens[1]) % modulus
	inverse = get_modular_inverse(a, modulus)

	return (b * inverse) % modulus


def guess_increment(givens: 'list[int]', modulus: int, multiplier: int) -> int:
	return (givens[1] - givens[0] * multiplier) % modulus


# http://www-math.ucdenver.edu/~wcherowi/courses/m5410/exeucalg.html
def get_modular_inverse(a: int, modulus: int) -> int:
	dividends = [modulus]
	divisors = [a]
	quotients = []
	remainders = []

	while True:
		quotients.append(dividends[-1] // divisors[-1])
		remainders.append(dividends[-1] - quotients[-1] * divisors[-1])

		if remainders[-1] == 0:
			break

		dividends.append(divisors[-1])
		divisors.append(remainders[-1])

	ps = [0, 1]
	for i in range(len(quotients) - 1):
		ps.append((ps[-2] - ps[-1] * quotients[i]) % modulus)

	return ps[-1]


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
	prime = get_prime_factors(abs(n))
	count = len(prime)
	out = set()

	if all(p == prime[0] for p in prime):
		p = prime[0]
		f = p
		while f < abs(n):
			f*=p
			out.add(f)
		return out


	for i in range(0,2**count):
		factor = 1
		for j in range(0, count):
			factor *= prime[j] if (i>>j)%2 else 1
		out.add(factor)
	return out


if __name__ == '__main__':
	main()

