import { Router } from 'express'
import { getUsers, createUser, getUser, updateUser, deleteUser } from '../controllers/userController'

const router = Router()

router.get("/", (req, res) => getUsers(req, res))

router.post('/', (req, res) => createUser(req, res))

router.get("/:id", (req, res) => getUser(req, res))

router.put("/:id", (req, res) => updateUser(req, res))

router.delete("/:id", (req, res) => deleteUser(req, res))

module.exports = router