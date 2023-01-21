## Laravel Queues

### Setup
`php artisan queue:table`

"sync", "database", "beanstalkd", "sqs", "redis", "null" as driver.
- Sync will process a job as it is

- Create jobs with `php artisan make:job JobName`
- Push a job onto a queue with `dispatch(new JobName)` in a class e.g. controller 
- In local development, run the queue with `php artisan queue:work`