# Change Log
All notable changes to this project will be documented in this file.

## Sep 7, 2022 Update

### Added
-	Started adding login/register page | not operational

## Sep 6, 2022 Update

### Changes
-	Upgraded to newest version of svelte w/ changed page routing
-	Starting to implement backend through Svelte-kit instead of deticated server

## Sep 4, 2022 Update

### Releases
-	Added read reciepts to sent msgs
-	By default show time reciept of last msg in thread
-	Started implementing message post
-	Added unread status

### Changes
-	Tried implementing backend [fail]

## Sep 1-2, 2022 Update

### Changes
-	Looking into also running the backend through sveltekit [coming soon]

### Releases
-	Setup global stores of current user w/ svelte
-	Built most of the /chat page
-	Added Vercel analytics to project

### Fixes
-	Prevent iPhone from auto zooming in on chat message input 

## Aug 9, 2022 Update

### Releases
-	Vercel auto-deploy setup

## Aug 8, 2022 Update

### Releases
-	Started experimenting on the homepage UI
-	Created colorHash function (using Apple's color pallete | Google's are the commented out colors)

## Aug 7, 2022 Update

### Releases
-	Sorted messages on backend to be truly DISTINCT
-	Finished general ``./threads`` page's UI (still need to create ``colorHash()``)

## Aug 5, 2022 Update

### Releases
-	Added endpoints for reading and sending messages
-	Added endpoint to view all threads with their most recent messages and read status.
-	Built UI shell of app | Header, Button and Icon
-	Started building UI for threads page, loading static data.
-	Preload back arrow by loading it and hiding when not in use.

## Aug 4, 2022 Update

### Bug fixes
-	Got cookie middleware working with test cookie value

### Releases
-	Started building out express server with some endpoints.
-	[notice] ``access_control`` is working with static info.

## Aug 3, 2022 Update

### Releases
-	Created goals and a project timeline w/ a basic readme.

### Changes
-	Started setting up the new code base layout.
-	Deleted original code base ((v1.0-php)[https://github.com/nmfrankel/ChatService/tree/v1.0-php]) and cleared it from the project.