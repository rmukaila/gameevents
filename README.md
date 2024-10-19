# API Documentation

| API Endpoint                     | Method | Purpose/Behavior                                                                                                                                                  | Request Parameters               | Response                                                                                     |
|-----------------------------------|--------|------------------------------------------------------------------------------------------------------------------------------------------------------------------|----------------------------------|------------------------------------------------------------------------------------------------|
| `/api/level-success`              | GET   | Tracks the player's level completion and updates their score within their assigned room.                                                                          | `player_id` | Updates player score and assigns room if necessary.                                           |
|                                   |        | - Checks if the player is in a room for the current event.                                                                                                        |                                  |                                                                                            |
|                                   |        | - Assigns the player to a room if not already in one (based on their country, ensuring the room doesn't exceed 50 players).                                       |                                  |                                                                                            |
|                                   |        | - Increments the player's score within the room.                                                                                                                 |                                  |                                                                                            |
| `/api/event-score-list/{room_id}` | GET    | Returns the list of players in a specific room, sorted by their scores in descending order.                                                                       | `room_id`                        | A list of players with their scores, ranked from highest to lowest.                          |
| `/api/all-rooms-score-list`       | GET    | Provides a list of all rooms created for the event, along with the total score for each room.                                                                     | None                             | A list of rooms, each containing:                                                            |
|                                   |        |                                                                                                                                                                  |                                  | - `room_id`: The ID of the room.                                                             |
|                                   |        |                                                                                                                                                                  |                                  | - `total_score`: The sum of all players’ scores in the room.                                 |
| `/api/create-event`               | POST   | Creates a new event for the game.                                                                                                                                 | `name`, `start_date`, `end_date`, `is_active`  | Event created with the specified parameters.                                                 |
|                                   |        |                                                                                                                                                                  | **Sample Payload:**               |                                                                                            |
|                                   |        |                                                                                                                                                                  | ```json                                                                                     |
|                                   |        |                                                                                                                                                                  | {                                                                                           |
|                                   |        |                                                                                                                                                                  |   "name": "The Badass5",                                                                     |
|                                   |        |                                                                                                                                                                  |   "start_date": "2024-11-08 12:00:00",                                                       |
|                                   |        |                                                                                                                                                                  |   "end_date": "2024-11-16 10:00:00",                                                         |
|                                   |        |                                                                                                                                                                  |   "is_active": 1                                                                             |
|                                   |        |                                                                                                                                                                  | }                                                                                           |
| `/api/create-player`              | POST   | Registers a new player in the system.                                                                                                                             | `name`, `country`                | Player record is created with the provided name and country.                                 |
| `/api/reward-players`             | GET   | Rewards the top players in each room based on their rankings at the end of the event.                                                                             | `event_id`                       | Rewards distributed based on the players' rankings in their rooms.                           |


# Installation Guide

## Table of Contents
- [Introduction](#introduction)
- [Prerequisites](#prerequisites)
- [Getting Started](#getting-started)
  - [Step 1: Clone the Repository](#step-1-clone-the-repository)
  - [Step 2: Change Directory](#step-2-change-directory)
  - [Step 4: Install Dependencies](#step-4-install-dependencies)
  - [Step 5: Build the Docker Containers](#step-5-build-the-docker-containers)
  - [Step 6: Generate the Application Key](#step-6-generate-the-application-key)
  - [Step 7: Run Migrations (Optional)](#step-7-run-migrations-optional)
  - [Step 8: Access the Application](#step-8-access-the-application)
  - [Step 9: Stopping the Containers](#step-9-stopping-the-containers)
  - [Step 10: Run the queue job](#step-10-run-queue-job)
  - [Step 11: Access the Database GUI (Phpmyadmin)](#step-11-phpmyadmin-ui)
  - [Step 12:This is optionsl. Run the database seeder (optional) ](#step-11-)
- [Additional Commands](#additional-commands)
- [Conclusion](#conclusion)

## Introduction

This repository contains a Laravel project utilizing Laravel Sail for a smooth development experience using Docker.

## Prerequisites

Before you begin, ensure you have the following installed on your WINDOWS machine:
- **NOTE**: the .env file has been intentionaly uploaded for ease of setup so you don't need to create one anymore
- **Docker**: Laravel Sail utilizes Docker for its development environment. Make sure Docker is installed and running with wsl enabled to use wsl.
- **Git**: To clone the project repository from GitHub.
- **Composer**: Used for managing PHP dependencies (if not already included in the Sail container).

## Getting Started

### Step 1: Clone the Repository

Open your WSL2 terminal and run the following command to clone the Laravel Sail project from GitHub:

```bash
Clone the repository:
git clone https://github.com/rmukaila/gameevents.git

or (for ssh)

git clone git@github.com:rmukaila/gameevents.git

Step 2: Change Directory
Navigate into the project directory:
cd your-laravel-sail-repo


Step 4: Install Dependencies
Run the following command to install the Composer dependencies:

./vendor/bin/sail composer install

Step 5: Build the Docker Containers
Start the Sail environment and build the Docker containers:

./vendor/bin/sail up
This command will start all necessary services defined in the docker-compose.yml file, .

Step 6: Generate the Application Key
While the containers are running, you may need to generate the application key for Laravel. Open another terminal window and run:

./vendor/bin/sail artisan key:generate
Step 7: Run Migrations 
Run the following command to create the database schema:
./vendor/bin/sail artisan migrate

Step 8: Access the Application
Once the containers are up and running, you can access your Laravel application in your web browser at:
http://localhost

Step 9: How to stop the containers
Once the containers are up and running, you can stop them with the following command:
./vendor/bin/sail down

Step 10: Run the queue job with this command
./vendor/bin/sail queue:work
This listens for any queued jobs and executes them. It's necessary since the application uses queues

Step 11: Access the Database GUI (Phpmyadmin)
When the containers are all app and running visit the phpmyadmin dasboard here:
localhost:8081

Username: sail
password: password


