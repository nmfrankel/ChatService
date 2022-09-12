import { json, error } from '@sveltejs/kit'
import type { RequestHandler } from './$types'
import { prisma } from '$lib/db'

// GET:    loads distinct messages (threads) between current [user] and [partner]'s id
export const GET: RequestHandler = async ({ locals, params }) => {
	// SECURITY CHECK: confirm user has access
	// SECURITY CHECK: confirm user has access
	// read locals.userid cookie to confirm user, use JWT or encrypted data for cookie

	const userId = params.userId

	let messages = await prisma.msg.findMany({
		distinct: ['senderId', 'receiverId'],
		where: {
			OR: [
				{
					senderId: userId
				},
				{
					receiverId: userId
				}
			]
		},
		orderBy: {
			posted: 'desc'
		},
		// include:{
		// 	_count: {
		// 		select:{ id: my_id }
		// 	}
		// },
		include: {
			sender: {
				select: {
					id: true,
					email: true,
					handle: true,
					first: true,
					last: true,
					phone: true
				}
			},
			receiver: {
				select: {
					id: true,
					email: true,
					handle: true,
					first: true,
					last: true,
					phone: true
				}
			}
		}
	})

	let distinct: (string | boolean)[] = []
	const modifiedMessages = await Promise.all(
		messages
			.map(async (thread) => {
				const outgoing = thread.sender.id === userId,
					otherUser = outgoing ? thread.receiver : thread.sender

				// keep track if otherUser is unique
				if (distinct.indexOf(otherUser.id) >= 0) return distinct.push(false)
				distinct.push(otherUser.id)

				// run query to check whether thread is unread
				const isRead = await prisma.msg.findFirst({
					where: {
						senderId: otherUser.id,
						receiverId: userId
					},
					orderBy: {
						posted: 'desc'
					},
					select: {
						metadata: true
					}
				})

				return {
					...thread,
					isRead: isRead ? isRead.metadata.search(userId) >= 0 : false,
					outgoing,
					otherUser,
					sender: undefined,
					receiver: undefined
				}
			})
			.filter((undefined, i) => distinct[i] !== false)
	)

	return json(modifiedMessages)
}

// PATCH:  Gives the option to archive a thread
export const PATCH: RequestHandler = async ({ request, locals, params }) => {
	throw error(400, 'An error occured while processing your request.')
}

// DELETE: Delete's a thread on the [user]'s side
export const DELETE: RequestHandler = async ({ request, locals, params }) => {
	throw error(400, 'An error occured while processing your request.')
}
