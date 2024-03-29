// See https://kit.svelte.dev/docs/types#app
// for information about these interfaces
// and what to do when importing types
declare namespace App {
	interface Locals {
		user: UserToken | null
	}

	// interface PageData {}

	// interface Platform {}
}

interface UserToken {
	sub: string
	given_name: string
	family_name: string
	handle?: string
	role: 'ADMIN' | 'USER' | 'DISABLED' | string
	iat?: number
	exp?: number
}
