<?php
require '../bootstrap.php';

use core\router\Routing;
use core\view\Parser;

$file = <<<TPL
{% if latest_question_list %}
    <ul>
    {% for question in latest_question_list %}
        <li><a href="/polls/{{ question.id }}/">{{ question.question_text }}</a></li>
    {% endfor %}
    </ul>
{% else %}
    <p>No polls are available.</p>
{% endif %}
TPL;
$code = Parser::generateCode($file);
$latest_question_list = null;
$html = null;
eval($code);
echo $html;
