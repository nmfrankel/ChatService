import { json } from '@sveltejs/kit'
import type { RequestHandler } from './$types'
import { pusher } from '$lib/utils/pusher.server'

export const POST: RequestHandler = async ({ request }) => {
	const body = await request.text()
	const socketId = body.match(/socket_id=([^&]*)/)?.[1] ?? ''
	const channel = body.match(/channel_name=([^&]*)/)?.[1] ?? ''

	const authResponse = pusher.authorizeChannel(socketId, channel)
	return json(authResponse)
}
