    <?php

    $greg = new Player(400);
    $jade = new Player(800);

    echo sprintf(
        'Greg à %.2f%% chance de gagner face a Jade',
        Encounter::probabilityAgainst($greg->getLevel(), $jade->getLevel())*100
    ).PHP_EOL;

    $gregNewLevel = 0;
    $jadeNewLevel = 0;
    Encounter::setNewLevel($gregNewLevel, $jade->getLevel(), Encounter::RESULT_WINNER);
    Encounter::setNewLevel($jadeNewLevel, $greg->getLevel(), Encounter::RESULT_LOSER);

    $greg->setLevel($gregNewLevel + $greg->getLevel());
    $jade->setLevel($jadeNewLevel + $jade->getLevel());

    echo sprintf(
        'les niveaux des joueurs ont évolués vers %s pour Greg et %s pour Jade',
        $greg->getLevel(),
        $jade->getLevel()
    );

    exit(0);

    class Player{
        public $level;

        public function __construct($level){
            $this->level = $level;
        }

        public function getLevel(){
            return $this->level;
        }

        public function setLevel($level){
            $this->level = $level;
            return $this;
        }
    }

    class Encounter{
        const RESULT_WINNER = 1;
        const RESULT_LOSER = -1;
        const RESULT_DRAW = 0;
        const RESULT_POSSIBILITIES = [self::RESULT_WINNER, self::RESULT_LOSER, self::RESULT_DRAW];

        public static function probabilityAgainst(int $levelPlayerOne, int $againstLevelPlayerTwo){
            return 1/(1+(10 ** (($againstLevelPlayerTwo - $levelPlayerOne)/400)));
        }

        public static function setNewLevel(int &$levelPlayerOne, int $againstLevelPlayerTwo, int $playerOneResult){
            if (!in_array($playerOneResult, self::RESULT_POSSIBILITIES)){
                trigger_error(sprintf('Invalid result. Expected %s',implode(' or ', self::RESULT_POSSIBILITIES)));
            }

            $levelPlayerOne += (int) (32 * ($playerOneResult - self::probabilityAgainst($levelPlayerOne, $againstLevelPlayerTwo)));
        }
    }

    exit(0);