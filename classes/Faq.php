<?php
/**
FAQ page.
PHP 7.4+
@author Sabrina Markon
@copyright 2018 Sabrina Markon, PHPSiteScripts.com
@license LICENSE.md
 **/
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

class Faq {

    private $pdo;
    private $question;
    private $answer;
    private $lastpositionnumber;
    private $positionnumber;

    public function getAllFaqs(): array {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from faqs order by positionnumber";
        $q = $pdo->prepare($sql);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $faqs = $q->fetchAll();
        $faqarray = array();
        foreach ($faqs as $faq) {
            array_push($faqarray, $faq);
        }

        Database::disconnect();

        return $faqarray;
    }

    private function getLastPositionNumber(): int {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select positionnumber from faqs order by positionnumber";
        $q = $pdo->prepare($sql);
        $q->execute();
        $lastpositionnumber = $q->fetch() ?? 0;
        $positionnumber = $lastpositionnumber["positionnumber"] + 1;

        Database::disconnect();

        return $positionnumber;
    }

    public function createFaq(array $post): string {
        
        $question = $post["question"];
        $answer = $post["answer"];
        $positionnumber = $this->getLastPositionNumber();

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "insert into faqs (question, answer, positionnumber) values (?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute([$question, $answer, $positionnumber]);

        Database::disconnect();

        return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>New FAQ was Added!</strong></div>";

    }

    public function saveFaq(array $post): string
    {

        $id = $post['id'];
        $question = $post['question'];
        $answer = $post['answer'];
        $positionnumber = $post['positionnumber'];

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "update faqs set question=?,answer=?,positionnumber=? where id=?";
        $q = $pdo->prepare($sql);
        $q->execute([$question, $answer, $positionnumber, $id]);

        Database::disconnect();

        return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>The FAQ was Saved!</strong></div>";
    }

    public function deleteFaq(int $id): string {

        $pdo = DATABASE::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "delete from faqs where id=?";
        $q = $pdo->prepare($sql);
        $q->execute([$id]);

        Database::disconnect();

        return "<div class=\"alert alert-success\" style=\"width:75%;\"><strong>The FAQ was Deleted!</strong></div>";
    }
}