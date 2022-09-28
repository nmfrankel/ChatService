import type { PageServerLoad } from './$types'
import { prisma } from '$lib/utils/db.server'

// GET:    pre-load messages between current [user] and [partner]'s id
export const load: PageServerLoad = async ({ locals, params }) => {
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
				posted: 'asc'
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

	return {
		msgs: messages
	}
}
