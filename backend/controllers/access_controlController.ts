import { Request, Response } from 'express'
// import { getUser } from './userController'

// @desc    Create a User
// @route   POST /access_control/login
export const login = async (req: Request, res: Response) => {
	const { email, pswd } = req.body

	if(email === 'test@example.com' && pswd === 'Testing123!')
		res.cookie('user', 'loggedIn: true', { maxAge: 600000, httpOnly: true }).redirect('/')

	res.json({ message: 'Email or password do not seem to match' })
}