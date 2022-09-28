import { json, error } from '@sveltejs/kit'
import type { RequestHandler } from './$types'
import { prisma } from '$lib/utils/db.server'
import { hash } from '$lib/utils/encryption.server'

// POST:   Attempt to create a new user
export const POST: RequestHandler = async ({ request, locals }) => {
	const { given_name, family_name, email, phone, pswd } = await request.json()

	// check for and notify user of errors
	if (!email || email.length < 3) throw error(401, 'A valid email is required to register')
	else if (!phone || phone.replace(/\D/, '').length < 10)
		throw error(401, 'A valid phone number is required to register')
	else if (!given_name || given_name.length < 3)
		throw error(401, 'A valid first name is required to register')
	else if (!family_name || family_name.length < 3)
		throw error(401, 'A valid last name is required to register')
	else if (!pswd || pswd.search(/[\w\d]{8,}/) === -1)
		throw error(401, 'A 8 character password is required to register')

	const user = await prisma.user.create({
		data: {
			role: 'USER',
			email,
			pswd: hash(pswd),
			handle: '',
			given_name,
			family_name,
			phone
		},
		select: {
			sub: true,
			given_name: true,
			family_name: true,
			role: true
		}
	})

	// send a welcome message to new user
	await prisma.msg.create({
		data: {
			senderId: '1',
			receiverId: user.sub,
			content: `Hi ${user.given_name}, welcome to the platform.`,
			metadata: ''
		}
	})

	// login user
	locals.user = { ...user }

	return json(user)
}
