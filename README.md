_This information is under construction_

## Dependencies

[Instagram realtime api](http://instagram.com/developer/realtime/) Real-time photo updates provide your application with instant notifications of new photos as they are posted on Instagram.
The most interesting way to view the world is live, as it happens. By adopting parts of the Pubsubhubub protocol, and through the use of a couple simple web hooks, Instagram has been able
to create a system where your application gets notified of new photos as they're posted. Instead of polling the Instagram servers to check to see if there are new photos available,
you can rely upon the Instagram servers to POST to a callback URL on your server when new data is available.

## Scripts
* __callback.php__ is a php script which receives the POST data
* __mysql__ folder with some necessary connection details

