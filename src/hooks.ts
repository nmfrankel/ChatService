import type { Handle } from '@sveltejs/kit'
import * as cookie from 'cookie'
import { readPayload, validateToken, generateToken } from '$lib/utils/token.server'

export const handle: Handle = async ({ event, resolve }) => {
	const cookies = cookie.parse(event.request.headers.get('cookie') || ''),
		user = readPayload(cookies.user)
	event.locals.user = user

	const response = await resolve(event)

	// refresh exp on userToken
	if (event.locals.user?.sub) {
		response.headers.set(
			'set-cookie',
			cookie.serialize('user', generateToken(event.locals.user), {
				path: '/',
				httpOnly: true
			})
		)
	}

	return response
}
