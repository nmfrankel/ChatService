Last updated 11/19/2021

**FRONTEND**
HIGH PRIORITY
-	Get chat.html working to replace legacy chat.php and then push new build layout to github
*		Set CSS for corners curved correctly
*		Show time if messages within X minutes apart from each other
*		Show loading animation
-	Add color to thread bubbles (system will use same color on chat.php bubble)

LOW PRIORITY
-	change <header> to position: fixed; with the scroll bar put on the <main> element
-	Have an option to toggle dark theme | document.documentElement.classList.add('dark')


**BACKEND**
HIGH PRIORITY
-	Update API response and redefined what should be expected
-	Hide secret_keys in encryption function

LOW PRIORITY
-	Build out an API accessable for the public, key and all
-


**IDEAS**
-	support @mentions and #channels/rooms
-	Change header bar to a white background
-	create method for how version numbers change
-	look into auto-depoly on commit
-	readableTime() '< 1 min' | '< 1 minute ago'
-	readableTime() up to an hour write '{X} min'
-	client/{space}/{group}/{channel}?redirect=null
-	create /status to run and track uptime available on status.example.com
-	admins can control chat
-	track user typing to show to other user