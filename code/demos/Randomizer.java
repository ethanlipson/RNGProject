import java.util.Random;

class Randomizer {

	private static final long multiplier = 25214903917L;
	private static final long addend = 11;
	private static final long mod = 1L << 48;

	private static long lcg(long state) {
		return (multiplier * state + addend) & (mod - 1);
	}

	public static void main(String[] args) {

		Random random = new Random();
		int r1 = random.nextInt();
		int r2 = random.nextInt();

		long l1 = Integer.toUnsignedLong(r1);
		System.out.println("r1 = " + l1);
		long l2 = Integer.toUnsignedLong(r2);
		System.out.println("r2 = " + l2);
		System.out.println();

		for (int i = 0; i < 65536; i++) {
			long seed = (l1 << 16) + i;
			if (lcg(seed) >> 16 == l2) {
				System.out.println("Seed found: " + seed);
				System.out.println("1st Next: " + (lcg(seed) >> 16));
				System.out.println("2nd Next: " + (lcg(lcg(seed)) >> 16));
				break;
			}
		}

		int r3 = random.nextInt();
		long l3 = Integer.toUnsignedLong(r3);
		System.out.println();
		System.out.println("r3 = " + l3);

	}
}