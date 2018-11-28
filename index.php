<?php
/**
 * Game short description for file
 *
 * Game long description for file (if any)...
 *
 * PHP version 7
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License <https://www.gnu.org/licenses/> for more
 * details.
 *
 * @category  Game
 * @package   Game
 * @author    James Evans <info@jamesevans.net>
 * @copyright 2018 James Evans
 * @license   https://www.gnu.org/licenses/ GNU GPLv3
 * @version   GIT: $Id$ In development.
 * @link      https://www.jamesevans.net/
 */

namespace FishingGame;

ini_set('display_errors', 1);
error_reporting(E_ALL);

/**
 * Constants
 */
const MIN_LINE_STRENTH = 1;
const MAX_LINE_STRENTH = 4;
const MIN_TARGET_SCORE = 10;
const MAX_TARGET_SCORE = 40;
const LIVES = 3;
const FISH = array(
    array('type' => 'Mackerel', 'number' => 10, 'strength' => 1),
    array('type' => 'Bass', 'number' => 8, 'strength' => 2),
    array('type' => 'Cod', 'number' => 6, 'strength' => 3),
    array('type' => 'Tuna', 'number' => 4, 'strength' => 4),
    array('type' => 'Shark', 'number' => 1, 'strength' => 5),
);

/**
 * Fish
 */

class Fish
{
    public $type;
    public $strength;

    public function __construct($type, $strength)
    {
        $this->type = $type;
        $this->strength = $strength;
    }
}

/**
 * Sea
 */

class Sea
{
    public $fish = array();

    public function __construct()
    {
        if (isset($_SESSION['fishInSea'])) {
            $this->fish = $_SESSION['fishInSea'];
        } else {
            $this->init();
        }
    }

    public function init()
    {
        $fishies = array();

        foreach (FISH as $fish) {
            for ($i = 0; $i < $fish['number']; $i++) {
                array_push($fishies, new Fish(
                    $fish['type'],
                    $fish['strength']
                ));
            }
        }

        $this->fish = $fishies;
        $_SESSION['fishInSea'] = $this->fish;
    }


    public function fishInTheSea()
    {
        $fishInTheSea = array();

        foreach ($this->fish as $fish) {
            if (!isset($fishInTheSea[$fish->type])) {
                $fishInTheSea[$fish->type] = 1;
            } else {
                $fishInTheSea[$fish->type]++;
            }
        }

        return $fishInTheSea;
    }

    public function catchFish($fishCaught)
    {
        $numFish = count($this->fish);
        $randomFish = rand(0, $numFish-1);

        $fish = $this->fish[$randomFish];
        unset($this->fish[$randomFish]);
        $this->fish = array_values(array_filter($this->fish));

        $_SESSION['fishInSea'] = $this->fish;

        $fishCaught->addCatch($fish);
    }
}

/**
 * Sea
 */

class FishCaught
{
    public $fish = array();

    public function __construct()
    {
        if (isset($_SESSION['fishCaught'])) {
            $this->fish = $_SESSION['fishCaught'];
        } else {
            $this->init();
        }
    }

    public function init()
    {
        $this->fish = array();
        $_SESSION['fishCaught'] = $this->fish;
    }

    public function fishCaught()
    {
        $fishCaught = array();

        foreach ($this->fish as $fish) {
            if (!isset($fishCaught[$fish->type])) {
                $fishCaught[$fish->type] = 1;
            } else {
                $fishCaught[$fish->type]++;
            }
        }

        return $fishCaught;
    }

    public function addCatch($fish)
    {
        array_push($this->fish, $fish);
        $_SESSION['fishCaught'] = $this->fish;
    }
}

/**
 * The Bones
 */

session_start();

$sea = new Sea();
$fishCaught = new FishCaught();

if (isset($_POST['fish'])) {
    $fish = $sea->catchFish($fishCaught);
}

if (isset($_POST['reset'])) {
    $sea->init();
    $fishCaught->init();
}

/**
 * Output buffer callback function
 *
 * @param string $buffer Output buffer
 *
 * @return string $buffer
 */
function OBCallback($buffer)
{
    return (str_replace("not working", "working", $buffer));
}

ob_start("FishingGame\OBCallback");
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <title>The HTML5 Herald</title>
        <meta name="description" content="HTML5 Template">
        <meta name="author" content="James Evans <info@jamesevans.net>">

        <style type="text/css">
            form {
                margin-top: 1.5em;
            }
            form input {
                font-size: 1.5em;
                cursor: pointer;
            }
        </style>
    </head>

    <body>
        <h1>Fish in the sea</h1>
        <table border="1">
            <tr>
                <th>Type</th>
                <th>Number of fish</th>
            </tr>
<?php foreach ($sea->fishInTheSea() as $type => $number) { ?>
            <tr>
                <td><?php echo $type ?></td>
                <td><?php echo $number ?></td>
            </tr>
<?php } ?>
        </table>

        <h1>Fish caught</h1>
        <table border="1">
            <tr>
                <th>Type</th>
                <th>Number of fish</th>
            </tr>
<?php foreach ($fishCaught->fishCaught() as $type => $number) { ?>
            <tr>
                <td><?php echo $type ?></td>
                <td><?php echo $number ?></td>
            </tr>
<?php } ?>
        </table>

        <form method="post" action=".">
            <input type="submit" name="fish" value="Sling your hook!" />
            <input type="submit" name="reset" value="Start again" />
        </form>
    </body>
</html>

<?php
ob_end_flush();

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */
