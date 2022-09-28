import { json, error, redirect } from '@sveltejs/kit'
import type { RequestHandler } from './$types'
import { prisma } from '$lib/utils/db.server'

// GET:    loads distinct messages (threads) between current [user] and [partner]'s id
export const GET: RequestHandler = async ({ locals, params }) => {
	const { user } = locals

	if (!user || user.sub !== params.userId) {
		throw redirect(302, '/login')
	}

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
		include: {
			sender: {
				select: {
					sub: true,
					// email: true,
					handle: true,
					given_name: true,
					family_name: true
					// phone: true
				}
			},
			receiver: {
				select: {
					sub: true,
					// email: true,
					handle: true,
					given_name: true,
					family_name: true
					// phone: true
				}
			}
		}
	})

	let distinct: (string | boolean)[] = []
	const modifiedMessages = await Promise.all(
		messages
			.map(async (thread) => {
				const outgoing = thread.sender.sub === userId,
					partner = outgoing ? thread.receiver : thread.sender

				// keep track if partner is unique
				if (distinct.indexOf(partner.sub) >= 0) return distinct.push(false)
				distinct.push(partner.sub)

				// run query to check whether thread is unread
				const isRead = await prisma.msg.findFirst({
					where: {
						senderId: partner.sub,
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
					partner,
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
