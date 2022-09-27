import type { Prisma } from '@prisma/client'
import { prisma } from '$lib/utils/db.server'
import { hash } from '$lib/utils/encryption.server'

const currentTime = new Date().getTime(),
	generateTimestamp = (secondsOffset: number) => {
		return new Date(currentTime - secondsOffset * 1000).toISOString()
	}

let pushedUsers: Prisma.UserCreateInput[] = []
const userData = [
	{
		sub: '1',
		role: 'USER',
		email: 'nosson_frankel@gmail.com',
		pswd: hash('Testing123!'),
		handle: 'nmfrankel',
		given_name: 'Nosson',
		family_name: 'Frankel',
		phone: '0534733971'
	},
	{
		sub: undefined,
		role: 'USER',
		email: 'leue__@gmail.com',
		pswd: hash('S3curE!10'),
		handle: 'nm_frankel',
		given_name: 'Dev',
		family_name: 'Frankel',
		phone: '534733971'
	},
	{
		sub: undefined,
		role: 'USER',
		email: 'nachibohen@gmail.com',
		pswd: 'must_reset',
		handle: 'DJ Nachman',
		given_name: 'Nachman',
		family_name: 'Tester',
		phone: '7189304820'
	},
	{
		sub: undefined,
		role: 'USER',
		email: 'pmingber@gmail.com',
		pswd: 'must_reset',
		handle: 'PM Ingber',
		given_name: 'PM',
		family_name: 'Ingber',
		phone: '0533180351'
	},
	{
		sub: undefined,
		role: 'USER',
		email: 'another_person@gmail.com',
		pswd: 'must_reset',
		handle: 'Another Person',
		given_name: 'Another',
		family_name: 'Person',
		phone: '7182534630'
	},
	{
		sub: undefined,
		role: 'ADMIN',
		email: 'aharin26@gmail.com',
		pswd: 'must_reset',
		handle: 'AM Leonard',
		given_name: 'Aharon Meir',
		family_name: 'Leonard',
		phone: '3235615952'
	},
	{
		sub: undefined,
		role: 'USER',
		email: 'ajlichtschein@gmail.com',
		pswd: 'must_reset',
		handle: 'AJ 23',
		given_name: 'AJ',
		family_name: 'Lichtshein',
		phone: '9179692634'
	}
]

async function main() {
	console.log(`Start seeding ...`)
	// Seed User table
	for (const u of userData) {
		const user: Prisma.UserCreateInput = await prisma.user.create({
			data: u
		})
		pushedUsers.push(user)
		console.log(`Created user with sub: ${user.sub}`)
	}

	const msgData: Prisma.MsgCreateInput[] = [
		{
			sender: {
				connect: {
					sub: pushedUsers[2].sub
				}
			},
			receiver: {
				connect: {
					sub: pushedUsers[0].sub
				}
			},
			msgType: 'text/plain',
			content: "It's PM's bithrday 🙂🎉🎈🥳",
			posted: generateTimestamp(604700),
			metadata: 'modified,read|1|' + generateTimestamp(604630)
		},
		{
			sender: {
				connect: {
					sub: pushedUsers[2].sub
				}
			},
			receiver: {
				connect: {
					sub: pushedUsers[0].sub
				}
			},
			msgType: 'text/plain',
			content: 'Please remind me tomorrow, I want to suprise him with a gift.',
			posted: '2022-08-05T09:27:00.441Z',
			metadata: 'modified'
		},
		{
			sender: {
				connect: {
					sub: pushedUsers[0].sub
				}
			},
			receiver: {
				connect: {
					sub: pushedUsers[3].sub
				}
			},
			msgType: 'text/plain',
			content: 'Happy bithrday 🙂🎉🎈🥳',
			posted: generateTimestamp(604630),
			metadata: 'read|1|' + generateTimestamp(603630)
		},
		{
			sender: {
				connect: {
					sub: pushedUsers[1].sub
				}
			},
			receiver: {
				connect: {
					sub: pushedUsers[0].sub
				}
			},
			msgType: 'text/plain',
			content: 'This is a test on the new type of id through cuid()',
			posted: generateTimestamp(60430),
			metadata: ''
		},
		{
			sender: {
				connect: {
					sub: pushedUsers[2].sub
				}
			},
			receiver: {
				connect: {
					sub: pushedUsers[0].sub
				}
			},
			msgType: 'text/plain',
			content: 'This is a test on the new type of id through cuid()',
			posted: generateTimestamp(50630),
			metadata: 'read|1|' + generateTimestamp(50430)
		},
		{
			sender: {
				connect: {
					sub: pushedUsers[0].sub
				}
			},
			receiver: {
				connect: {
					sub: pushedUsers[2].sub
				}
			},
			msgType: 'text/plain',
			content: 'Doing great and thanks for asking.',
			posted: generateTimestamp(40430),
			metadata: ''
		},
		{
			sender: {
				connect: {
					sub: pushedUsers[5].sub
				}
			},
			receiver: {
				connect: {
					sub: pushedUsers[6].sub
				}
			},
			msgType: 'text/plain',
			content: 'This message should not show up',
			posted: generateTimestamp(40404),
			metadata: ''
		},
		{
			sender: {
				connect: {
					sub: pushedUsers[6].sub
				}
			},
			receiver: {
				connect: {
					sub: pushedUsers[4].sub
				}
			},
			msgType: 'text/plain',
			content: 'This message should also not show up',
			posted: generateTimestamp(4000),
			metadata: ''
		},
		{
			sender: {
				connect: {
					sub: pushedUsers[5].sub
				}
			},
			receiver: {
				connect: {
					sub: pushedUsers[0].sub
				}
			},
			msgType: 'text/plain',
			content: "Here's the link for the new phone that I told you about...",
			posted: generateTimestamp(4000),
			metadata: 'read|1|' + generateTimestamp(3000)
		},
		{
			sender: {
				connect: {
					sub: pushedUsers[3].sub
				}
			},
			receiver: {
				connect: {
					sub: pushedUsers[0].sub
				}
			},
			msgType: 'text/plain',
			content: 'I forgot to remind you, seder will be regular time today.',
			posted: generateTimestamp(2000),
			metadata: ''
		},
		{
			sender: {
				connect: {
					sub: pushedUsers[0].sub
				}
			},
			receiver: {
				connect: {
					sub: pushedUsers[1].sub
				}
			},
			msgType: 'text/plain',
			content: 'What time does shabbos start tomorrow night?',
			posted: generateTimestamp(1000),
			metadata: ''
		},
		{
			sender: {
				connect: {
					sub: pushedUsers[0].sub
				}
			},
			receiver: {
				connect: {
					sub: pushedUsers[3].sub
				}
			},
			msgType: 'text/plain',
			content: 'Hey what up, big boy?',
			posted: generateTimestamp(0),
			metadata: ''
		}
	]

	// Seed Msg table
	for (const m of msgData) {
		const msg = await prisma.msg.create({
			data: m
		})
		console.log(`Created message with id: ${msg.id}`)
	}
	console.log(`Seeding finished.`)
}

main()
	.then(async () => {
		await prisma.$disconnect()
	})
	.catch(async (e) => {
		console.error(e)
		await prisma.$disconnect()
		process.exit(1)
	})
