# ChatService

A full featured chat app to help connect people with friends.

## How does it work?

DETaILS COMING SOON

## Development

You need [Node.js v16](https://nodejs.org/en/) for the frontend and a hosted database (I used [CockroachDB](https://cockroachlabs.com/)).

### Initialize the database

Prisma will do all the heavy lifting, all you need to do is update the [`DATABASE_URL`](https://github.com/nmfrankel/ChatService/blob/main/.env.example) enviornment variable.  
Note: When the database is created it gets seeded with a few demo accounts to play with, the seed data is at `/prisma/seed.js`.

```bash
npx prisma generate
```

### Run the server

The app is usually served at `http://localhost:5173/` if the port is available.

```bash
npm run dev
```

## Deployment

To deploy on Vercel click on the following button and remember to enter your `DATABASE_URL` variable for your database. If you plan to deploy the app elsewhere, you'll need to update the script names `"vercel-build"` and `"vercel-postbuild"` inside `/package.json`.

[![Deploy with Vercel](https://vercel.com/button)](https://vercel.com/new/clone?repository-url=https%3A%2F%2Fgithub.com%2Fnmfrankel%2FChatService)

## Contributing

Thank you for offering your services, I currently don't have the time to deligate tasks.  
Sorry 😟

## What I learned from V2

<!-- - Developed a REST API with role based access control (RBAC). -->

- Programmatically initialized and interacted with a **[cloud hosted database](https://cockroachlabs.com/)** using **[Prisma ORM](https://prisma.io/)**.
- Utilized **[Svelte-kit](https://kit.svelte.dev/)** and **[TypeScript](https://typescriptlang.org/)** for the user interface.
- Implemented CI/CD practices to auto-deploy on **[Vercel](https://vercel.com/)**, triggered by each code push to **[Github](https://github.com/)**.
