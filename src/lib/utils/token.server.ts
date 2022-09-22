import { generateChecksum } from './encryption.server'

// Generate (and refresh)/validate UserTokens similar to 0Auth's JWT token

export const readPayload = (userToken: string = ''): UserToken | null => {
	const rawPayload = userToken.split('.')?.[0] ?? '{}',
		asString = Buffer.from(rawPayload, 'base64').toString()
	return asString ? JSON.parse(asString) : null
}

export const generateToken = (payload: UserToken) => {
	const { ...userToken }: UserToken = {
			...payload,
			iat: payload.iat ?? new Date().getTime(),
			exp: new Date().getTime() + 2.4 * 24 * 60 * 60 * 1000
		},
		data = Buffer.from(JSON.stringify(userToken)).toString('base64'),
		signature = generateChecksum(JSON.stringify(userToken))
	return `${data}.${signature}`
}

export const validateToken = (token: string) => {
	const [payload, hashDigest] = token.split('.')
	return hashDigest === generateChecksum(Buffer.from(payload, 'base64').toString())
}

// Add users IP to prevent cookie theft: event.getClientAddress()
// Check if token didn't expire and IP matches inside validateToken()
