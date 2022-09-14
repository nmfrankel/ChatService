import { scryptSync, randomBytes, timingSafeEqual } from 'crypto'

export const hash = (plaintext: string) => {
	const salt = randomBytes(16).toString('hex')
	const hashedPassword = scryptSync(plaintext, salt, 64).toString('hex')

	return `${salt}:${hashedPassword}`
}

export const compareHash = (plaintext: string, cyphertext: string) => {
	const [salt, key] = cyphertext.split(':')
	const hashedBuffer = scryptSync(plaintext, salt, 64)

	const keyBuffer = Buffer.from(key, 'hex')
	const match = timingSafeEqual(hashedBuffer, keyBuffer)

	return match
}
