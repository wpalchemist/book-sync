# Book Sync

## Why I'm Building This

I have used [LibraryThing](http://www.librarything.com/) since 2006 to catalog [my books](http://www.librarything.com/catalog/Gwendydd).  I really love LibraryThing, but Goodreads also has a bunch of handy features, and more of my friends use Goodreads. So I want to catalog and review my books in both places, but entering my books in both places is a hassle.  I'm creating this plugin (to be accompanied by a Chrome browser extenssion) to help me sync my book catalog between LibraryThing, Goodreads, and my own WordPress site.

In the process, this plugin is a great way to demonstrate my back-end and front-end WordPress skills, including my experience with various APIs and Gutenberg.

I don't know if anyone else will ever want to use this, but it's something I need, so I'm happy to build it for myself.

## Project Scope
My plan for this plugin is to create a book catalog within WordPress which will store and display information about my books.  It will include WP-CLI commands to pull books from LibraryThing and Goodreads, and to push books to Goodreads (LibraryThing's API is read-only, so I can't push to LibraryThing).  I plan to use those commands to keep LibraryThing and Goodreads in sync.

I also plan to build a Chrome browser extension that will listen for me to create/edit a book in LibraryThing, and then use the WordPress API to create/edit a book in WordPress.

## Change of Scope 

[Goodreads just killed their API](https://joealcorn.co.uk/blog/2020/goodreads-retiring-API), so there goes any hope of integrating with Goodreads.
