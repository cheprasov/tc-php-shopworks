## Technical Questions  

> How long did you spend on the coding test? What would you add to your solution if you had more time?

Couple days in a relax mode.
  
> Why did you choose PHP as your main programming language?

About 12 years ago it was a really popular language for web development. I was a freelancer, and PHP & JS were enough for all my and clients needs.
  
> What is your favourite thing about Laravel?

It is small and simply and helps to create and run simple application easy.

> What is your least favourite?

Eloquent

> How would you track down a performance issue in production? Have you ever had to do this?

For tracking down a performance issue we need to have system data for analysis. The more parameters and metrics you have, the more easier and faster to identify, localize, and fix the problem.

We used for it monitoring tools like [Zabbix](https://www.zabbix.com/), [Graphite](http://graphite.readthedocs.io/) and [Pinba](http://pinba.org/).

Without monitoring data, we can use some [profiler](https://github.com/cheprasov/php-simple-profiler) or Stopwatch on production for test users only or some small % of real users for quick collect data of performance issue for analysis.

Also for avoid some performance issues, it is very important to know the slowest things in architecture of a project  (like network, database, third-party services and so on) and have strong software engineering skill to write optimized algorithms, sql queries, data structures and so on.
