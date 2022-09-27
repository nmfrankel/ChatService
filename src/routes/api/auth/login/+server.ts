import { json, error } from '@sveltejs/kit'
import type { RequestHandler } from './$types'
import { prisma } from '$lib/utils/db.server'
import { compareHash } from '$lib/utils/encryption.server'

// GET:    Check current login state
export const GET: RequestHandler = async ({ request, locals, setHeaders }) => {
	throw error(400, 'An error occured while processing your request.')
}

// POST:   Attempt [user] login and keep track
export const POST: RequestHandler = async ({ request, locals }) => {
	const { email, pswd } = await request.json(),
		user = await prisma.user.findFirst({
			where: {
				email,
				role: {
					not: 'DISABLED'
				}
			},
			select: {
				sub: true,
				role: true,
				pswd: true,
				handle: false,
				given_name: true,
				family_name: true
			}
		})

	// check for and notify user of errors
	if (!email) throw error(401, 'A valid email is required to login')
	else if (!pswd) throw error(401, 'A valid password is required to login')
	else if (!user) throw error(401, 'No user account was matched to the info entered')
	else if (!compareHash(pswd, user.pswd))
		throw error(401, 'No user account was matched to the info entered')

	// login user
	locals.user = {
		sub: user.sub,
		given_name: user.given_name,
		family_name: user.family_name,
		role: user.role
	}

	return json(locals.user)
}
