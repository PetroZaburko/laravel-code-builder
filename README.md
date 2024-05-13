## Generating laravel code from SQL table schema

### Description
Hello Laravel users!
This package allows you to generate code from the schema of your SQL table. The following entities are generated:
- [Controller](https://github.com/dev-lnk/laravel-code-builder/blob/master/docs/examples/controller.md)
- [Model](https://github.com/dev-lnk/laravel-code-builder/blob/master/docs/examples/model.md)
- [FormRequest](https://github.com/dev-lnk/laravel-code-builder/blob/master/docs/examples/request.md)
- [DTO](https://github.com/dev-lnk/laravel-code-builder/blob/master/docs/examples/dto.md)
- [AddAction](https://github.com/dev-lnk/laravel-code-builder/blob/master/docs/examples/add_action.md)
- [EditAction](https://github.com/dev-lnk/laravel-code-builder/blob/master/docs/examples/edit_action.md)
- [Route](https://github.com/dev-lnk/laravel-code-builder/blob/master/docs/examples/route.md)
- [Form](https://github.com/dev-lnk/laravel-code-builder/blob/master/docs/examples/form.md)
- [Table](https://github.com/dev-lnk/laravel-code-builder/blob/master/docs/examples/table.md)

These examples were generated from a table created from migration:
```php
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('title')->default('Default');
    $table->text('content');
    $table->foreignIdFor(User::class)
        ->nullable()
        ->constrained()
        ->nullOnDelete()
        ->cascadeOnUpdate();
    $table->smallInteger('sort_number')->default(0);
    $table->boolean('is_active')->default(0);
    $table->timestamps();
    $table->softDeletes();
});
```
### What is this package for?
This package allows you to significantly reduce the amount of routine code writing and focus on development.

### Installation
```shell
composer require dev-lnk/laravel-code-builder --dev
```
### Configuration:
Publish the package configuration file:
```shell
php artisan vendor:publish --tag=laravel-code-builder
```
### Usage
```shell
php artisan code:build user
```
You will be offered a list of your tables, choose which table to generate the code based on:
```shell
 ┌ Table ───────────────────────────────────────────────────────┐
 │   ○ migrations                                             │ │
 │   ○ password_reset_tokens                                  │ │
 │   ○ products                                               │ │
 │   ○ sessions                                               │ │
 │ › ● users                                                  ┃ │
 └──────────────────────────────────────────────────────────────┘
```
You can also specify part of the table name to shorten the list
```shell
php artisan code:build user us
 ┌ Table ───────────────────────────────────────────────────────┐
 │ › ● users                                                    │
 └──────────────────────────────────────────────────────────────┘
```
If you did not specify a `generation_path` in the configuration file, you will be offered 2 options:
```shell
 ┌ Where to generate the result? ───────────────────────────────┐
 │ › ● In the project directories                               │
 │   ○ To the generation folder: `app/Generation`               │
 └──────────────────────────────────────────────────────────────┘
```
In the first option, all files will be generated according to the folders of your app_path directory. If a file with the same name is found, you will be prompted to replace it:
```shell
app/Models/User.php was created successfully!
...
 ┌ Controller already exists, are you sure you want to replace it? ┐
 │ Yes                                                             │
 └─────────────────────────────────────────────────────────────────┘

app/Http/Controllers/UserController.php was created successfully!
...
```
In the second option, all files will be generated in the `app/Generation` folder
```shell
app/Generation/Models/User.php was created successfully!
...
```
In the `builders` configuration you can comment out those builders that you do not want to be executed
```php
use DevLnk\LaravelCodeBuilder\Enums\BuildType;

return [
    'builders' => [
        BuildType::MODEL,
//        BuildType::DTO,
//        BuildType::ADD_ACTION,
//        BuildType::EDIT_ACTION,
//        BuildType::REQUEST,
//        BuildType::CONTROLLER,
//        BuildType::ROUTE,
//        BuildType::TABLE,
        BuildType::FORM,
    ],
    //...
];
```
You can generate certain entities using flags:
```shell
php artisan code:build user --model --request
```
Available options for the only flag:
- `--model`
- `--request`
- `--DTO`
- `--addAction`
- `--editAction`
- `--controller`
- `--route`
- `--form`
- `--table`
- `--builder` - Generates all builders specified in the `builders` configuration + your specified flag, for example:
```shell
php artisan code:build user --builders --request
```
### Documentation
- **[Relationship](https://github.com/dev-lnk/laravel-code-builder/blob/master/docs/relationship.md)**
- **[Customization](https://github.com/dev-lnk/laravel-code-builder/blob/master/docs/customization.md)**
- **[For contributors](https://github.com/dev-lnk/laravel-code-builder/blob/master/docs/for_contributors.md)**