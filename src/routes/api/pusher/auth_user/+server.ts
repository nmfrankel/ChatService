import { json } from '@sveltejs/kit'
import type { RequestHandler } from './$types'
import { pusher } from '$lib/utils/pusher'

// POST:	Authenticate user
export const POST: RequestHandler = async ({ request }) => {
	const body = await request.text()
	const socketId = body.match(/socket_id=([^&]*)/)?.[1] ?? ''

	const user = {
		id: '0000-0000',
		user_info: {
			name: 'Nosson M Frankel'
		}
	}

	const authResponse = pusher.authenticateUser(socketId, user)
	return json(authResponse)
}
