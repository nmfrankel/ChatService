import { Request, Response } from 'express'
import { Prisma, PrismaClient } from '@prisma/client'

const prisma = new PrismaClient()


// @desc    Gets All Users
// @route   GET /users
export const getUsers = async (req: Request, res: Response) => {
	const users = await prisma.user.findMany()
	res.json(users)
}

// @desc    Create a User
// @route   POST /users/
export const createUser = async (req: Request, res: Response) => {
	const { role, email, pswd, handle, first, last, phone }: 
	{ role?: string, email: string, pswd:string, handle?:string, first: string, last: string, phone: string } = req.body

	const missingFields = !email || !first || !last || !phone
	if(missingFields){
		return res.json({ message: 'Unable to create user since required fields are missing' })
	}
	
	const userExists = await prisma.user.findFirst({ where: { phone } })
	if(userExists)
		return res.json({ message: 'Unable to create user since user already exists' })

	const result = await prisma.user.create({
		data: {
			role,
			email,
			pswd: pswd,// eventually encrypt
			handle,
			first,
			last,
			phone
		}
	})
	
	return res.status(201).json(result)
}

// @desc    Gets Single User
// @route   GET /users/:id
export const getUser = async (req: Request, res: Response) => {
	const { id } = req.params

	const user = await prisma.user.findUnique({
	  where: { id: Number(id) },
	})
	res.json(user)
}

// @desc    Update a User
// @route   PUT /users/:id
export const updateUser = async (req: Request, res: Response) => {
	const { id } = req.params

	const user = await prisma.user.findUnique({
		where: { id: Number(id) },
	})

	if(!user)
		return res.status(404)
			.json({ message: `User with ID ${id} was not found in the database` })

	const { role, email, pswd, handle, first, last, phone }: 
	{ role?: string, email: string, pswd:string, handle?:string, first: string, last: string, phone: string } = req.body
	
	const updatedUser = await prisma.user.update({
		where: { id: Number(id) },
		data: {
			role: role ?? user.role,
			email: email ?? user.email,
			pswd: pswd ?? user.pswd,// eventually encrypt
			handle: handle ?? user.handle,
			first: first ?? user.first,
			last: last ?? user.last,
			phone: phone ?? user.phone
		}
	})

	res.json(updatedUser)
}

// @desc    Delete a User
// @route   DELETE /users/:id
export const deleteUser = async (req: Request, res: Response) => {
	const { id } = req.params

	const user = await prisma.user.findUnique({
		where: { id: Number(id) },
	})

	if(!user)
		return res.status(404)
			.json({ message: `User with ID ${id} was not found in the database` })

	await prisma.user.delete({
		where: {
			id: Number(id),
		}
	})
	res.json({ message: 'User deleted successfully' })
}