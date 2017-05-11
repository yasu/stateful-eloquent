# Laravel 5 Eloquent State Machine

If you're familiar with my [AASM](https://github.com/aasm/aasm), then this is a similar take – just implemented in Laravel 5 for Eloquent classes.

## References

Forked from https://github.com/mikerice/stateful-eloquent

## Installation

### Step 1: Install Through Composer

```
composer require acacha/stateful-eloquent
```

### Step 2: Add the Service Provider

```php
Acacha\Stateful\Providers\StatefulServiceProvider::class,
```

### Step 3: Update your Eloquent Model

Your models should use the Stateful trait and interface

```php
use Acacha\Stateful\Traits\StatefulTrait;
use Acacha\Stateful\Contracts\Stateful;

class Transaction extends Model implements Stateful
{
    use StatefulTrait;
}
```

### Step 4: Create your Model States

Your models should have an array name `$states` that define your model states.

```php
/**
 * Transaction States
 *
 * @var array
 */
protected $states = [
    'draft' => ['initial' => true],
    'processing',
    'errored',
    'active',
    'closed' => ['final' => true]
];
```

### Step 5: Create your Model State Transitions

```php
/**
 * Transaction State Transitions
 *
 * @var array
 */
protected $transitions = [
    'process' => [
        'from' => ['draft', 'errored'],
        'to' => 'processing'
    ],
    'activate' => [
        'from' => 'processing',
        'to' => 'active'
    ],
    'fail' => [
        'from' => 'processing',
        'to' => 'errored'
    ],
    'close' => [
        'from' => 'active',
        'to' => 'close'
    ]
];

    /**
     * @return bool
     */
    protected function validateProcess()
    {
        $validate = true;
        if (!$validate) {
            $this->addValidateProcessMessage();
        }

        return $validate;
    }

    /**
     * @return bool
     */
    protected function validateActivate()
    {
        //dd("validateActivate");
        return true;
    }

    /**
     * @return bool
     */
    protected function validateFail()
    {
        //dd("validateFail");
        return true;
    }

    /**
     * @return bool
     */
    protected function validateClose()
    {
        //dd("validateClose");
        return true;
    }

    protected function beforeProcess() {
        //dd("doing something before entering processing state");
    }

    protected function afterProcess() {
        //dd("doing something after leaving processing state");
    }

```

## Database configuration

You model migration should have a state field like:

```php
class CreateModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model', function (Blueprint $table) {
            $table->increments('id');
            ...
            $table->string('state');
            ...
            $table->timestamps();
        });
    }
```

## Usage

```php
$transaction = new Transaction();

//Execute transition
$transaction->process();

//Check if a state is active (return true or false)
$transaction->active();
```

