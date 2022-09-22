import { json } from '@sveltejs/kit'
import type { RequestHandler } from './$types'
import { pusher } from '$lib/utils/pusher.server'

// GET:    Test pusher implemention
export const GET: RequestHandler = ({ url }) => {
	const userId = url.searchParams.get('userId')

	pusher.trigger(`private-chat-${userId}`, 'msg', {
		message: 'hello world'
	})

	return json({ sent: true })
}
