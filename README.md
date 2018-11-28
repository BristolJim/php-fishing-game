# PHP Fishing Game

## Task
Create a simple PHP driven fishing game, where the user clicks on a button to attempt to
catch a random fish. Each fish will have a score based on their strength. Should the user
catch enough fish to meet the target score, without losing all of their lives, then they will win
the game. Should the user lose all of their lives, or catch a shark, then the game is over.

When the user catches a fish, whose strength exceeds that of the set line strength, then they
will lose a life and no score will be added. However, should the user catch a fish that the
fisherman’s line strength can handle, then the fish will be deemed caught and the score of
that fish will be added to the game score. If the user’s game score meets the target score
then they have won. Once a fish is caught it is removed from the sea and cannot be caught
again. You should be able to start a new game once it is over.

## Initialisation requirements

* The fishing line strength will be set using a random integer between 1-4 (the
minimum/maximum strength of a catchable fish).
* The target score will be set using a random integer 10 - 40
* The total number of lives will be set to 3

You start the game with the following fish:

| Fish Type | Number of Fish |  Strength / Score |
|-----------|----------------|-------------------|
| Mackerel  | 10             | 1                 |
| Bass      | 8              | 2                 |
| Cod       | 6              | 3                 |
| Tuna      | 4              | 4                 |
| Shark     | 1              | 5                 |

## UI requirements

* Display all uncaught fish and their strengths
* Create buttons for catching a fish and starting a new game
* Show the following: Game Score / Target Score, Line Strength, Remaining Lives
* Display a text summary of all fish caught
* Display Win / Loss notifications

## Tools

You may only use PHP (procedural or OOP) / CSS / HTML however you cannot use any
libraries or frameworks. Sessions are allowed. The whole program should be written in a
single file and will need to be run directly from a web browser.

The UI only needs to be very simple, however you can advance on this if you wish.
