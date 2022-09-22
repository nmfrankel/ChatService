import { createHmac, scryptSync, randomBytes, timingSafeEqual } from 'crypto'

export const hash = (plaintext: string) => {
	const salt = randomBytes(16).toString('hex')
	const hashedPassword = scryptSync(plaintext, salt, 64).toString('hex')

	return `${salt}:${hashedPassword}`
}

export const compareHash = (plaintext: string, ciphertext: string) => {
	const [salt, key] = ciphertext.split(':')
	const hashedBuffer = scryptSync(plaintext, salt, 64)

	const keyBuffer = Buffer.from(key, 'hex')
	const match = timingSafeEqual(hashedBuffer, keyBuffer)

	return match
}

export const generateChecksum = (plaintext: string) => {
	const hmac = createHmac('sha256', import.meta.env.VITE_HASH_KEY)
		.update(plaintext)
		.digest('hex')
	return hmac
}
