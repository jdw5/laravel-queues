## Laravel Queues

### Setup
`php artisan queue:table`

"sync", "database", "beanstalkd", "sqs", "redis", "null" as driver.
- Sync will process a job as it is

- Create jobs with `php artisan make:job JobName`
- Push a job onto a queue with `dispatch(new JobName)` in a class e.g. controller 
- In local development, run the queue with `php artisan queue:work`


### Failed Jobs
- Implement a failed() method in the job class
- Alternatively use a listener
- Can set a retry limit and retry timeout


### Amazon SQS
- In config/queue, set the driver to sqs and include keys in environment file
- Create an account user on AWS with SQSFullAccess policy
- SQS prefix is the URL minus the queue name
- Ensure Amazon SDK is installed via `composer require aws/aws-sdk-php`


### Email Queueing
- `Mail::to($request->user())->send(new UserRegistered);`
- Queue it by changing `send` to `queue`