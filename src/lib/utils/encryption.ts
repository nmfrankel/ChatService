import { scryptSync, randomBytes, timingSafeEqual } from 'crypto'

export const hash = (input: string) => {
	const salt = randomBytes(16).toString('base64')
    const hashedPassword = scryptSync(input, salt, 64).toString('base64')

    return `${salt}:${hashedPassword}`
}

export const compareHash = (input: string, encryptedText: string) => {
    const [salt, key] = encryptedText.split(':')
    const hashedBuffer = scryptSync(input, salt, 64)
  
    const keyBuffer = Buffer.from(key, 'base64')
    const match = timingSafeEqual(hashedBuffer, keyBuffer)
    
	return match
}