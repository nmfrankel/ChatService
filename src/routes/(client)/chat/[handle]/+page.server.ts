import { json, error } from '@sveltejs/kit'
import type { PageServerLoad } from './$types'
import { prisma } from '$lib/utils/db.server'

// GET:    pre-load messages between current [user] and [partner]'s id
export const load: PageServerLoad = async ({ locals, params }) => {
	// SECURITY CHECK: confirm user has access
	// SECURITY CHECK: confirm user has access
	// read locals.userid cookie to confirm user, use JWT or encrypted data for cookie

	const userId = locals.user?.sub,
		partnerId = params.handle

	const messages = await prisma.msg
		.findMany({
			where: {
				OR: [
					{
						senderId: userId,
						receiverId: partnerId
					},
					{
						senderId: partnerId,
						receiverId: userId
					}
				]
			},
			// skip: 0,
			// take: 20,
			orderBy: {
				posted: 'desc'
			},
			select: {
				id: true,
				sender: {
					select: {
						sub: true,
						email: true,
						handle: true,
						given_name: true,
						family_name: true,
						phone: true
					}
				},
				receiver: {
					select: {
						sub: true,
						email: true,
						handle: true,
						given_name: true,
						family_name: true,
						phone: true
					}
				},
				msgType: true,
				content: true,
				posted: true,
				metadata: true
			}
		})
		.catch((err) => {
			return { err: err }
		})

	return Object.values(messages).reverse()
}
