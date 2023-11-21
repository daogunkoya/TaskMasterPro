

## Project Management Tool (API)

This project is a robust project management tool developed using Laravel, employing various design patterns like Repository, Event-Driven, Observer, and Strategic, aiming to enable efficient collaboration among users on projects, task management, progress monitoring, and status tracking. it also incorporate Sail, Passport for Authentication , Redis to manage Queue job


### Setup

#### Prerequisites

-  Laravel installed (minimum version 10.10) 
-  Sail configured (with Redis enabled) 

## Installation

 Clone the repository:
- git clone https://github.com/daogunkoya/TaskMasterPro
- cd taskmasterpro-app

 Install dependencies:
- composer install


 Copy the .env.example file to .env:
- cp .env.example .env
- cp .env.example .env.testing

#### Running the Application

- php artisan sail:install
- ./vendor/bin/sail up




### The API endpoints are:

## API Endpoints

### Users

- `POST /users`: User registration.
- `POST /users/login`: User login.
- `POST /users/refresh`: Refresh user token.
- `GET /users`: Get user details.

### Projects

- `GET /projects`: List all projects.
- `POST /projects`: Create a new project.
- `PUT /projects/{id}`: Update a project.
- `GET /projects/{id}`: Get details of a specific project.
- `GET /projects/{id}/tasks`: Get tasks of a specific project.
- `DELETE /projects/{id}`: Delete a project.

### Tasks

- `GET /tasks`: List all tasks.
- `POST /tasks`: Create a new task.
- `PUT /tasks/{id}`: Update a task.
- `GET /tasks/{id}`: Get details of a specific task.
- `GET /tasks/{id}/tasks`: Get tasks related to a specific task.
- `DELETE /tasks/{id}`: Delete a task.

### Task Assignment

- `POST /projects/{project}/tasks/{task}/assign`: Assign a task to a project.

### Project Statistics

- `GET /projects/statistics`: Retrieve project statistics.




## Testing

 Feature Tests
 To run feature tests:
- php artisan test --testsuite=Feature

 Unit Tests
 To run unit tests:
- php artisan test --testsuite=Unit




##   Authentication
API token authentication is mamangae with Passport
