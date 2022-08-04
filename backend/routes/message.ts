import { Router } from 'express'
// import { getUsers, getUser, createUser, updateUser, deleteUser } from '../controllers/userController'

const router = Router()

router.get('/', (req, res) => res.send('Working'))
// router.get("/", (req, res) => getUsers(req, res))

// router.post('/', (req, res) => createUser(req, res))

// router.get("/:id", (req, res) => getUser(req, res))

// router.patch("/:id", (req, res) => updateUser(req, res))

// router.delete("/:id", (req, res) => deleteUser(req, res))

module.exports = router