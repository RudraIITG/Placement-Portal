<?php
session_start(); // Start the session

// Check if session data is set
if (!isset($_SESSION['roll'])) {
    echo "<p>Please log in to access the test.</p>";
    exit; // Stop the script if session data is not set
}

// Define Questions and Answers
$questions = [
    'Statistics' => [
        [
            'question' => 'What is the mean of the following numbers: 5, 10, 15?',
            'options' => [
                'A' => '10',
                'B' => '15',
                'C' => '20',
                'D' => '25'
            ],
            'answer' => 'A'
        ],
        [
            'question' => 'What is the mode of the following set of numbers: 1, 2, 2, 3, 4?',
            'options' => [
                'A' => '1',
                'B' => '2',
                'C' => '3',
                'D' => '4'
            ],
            'answer' => 'B'
        ],
        [
            'question' => 'What is the variance of the numbers 2, 4, 4, 4, 5, 5, 7, 9?',
            'options' => [
                'A' => '4',
                'B' => '6',
                'C' => '8',
                'D' => '10'
            ],
            'answer' => 'B'
        ],
        [
            'question' => 'What is the probability of rolling a sum of 7 with two dice?',
            'options' => [
                'A' => '1/6',
                'B' => '1/12',
                'C' => '1/36',
                'D' => '1/2'
            ],
            'answer' => 'A'
        ],
        [
            'question' => 'In a normal distribution, what percentage of the data lies within one standard deviation of the mean?',
            'options' => [
                'A' => '50%',
                'B' => '68%',
                'C' => '95%',
                'D' => '99%'
            ],
            'answer' => 'B'
        ],
        [
            'question' => 'What is a Type I error?',
            'options' => [
                'A' => 'False positive',
                'B' => 'False negative',
                'C' => 'Correct decision',
                'D' => 'None of the above'
            ],
            'answer' => 'A'
        ],
        [
            'question' => 'What does the Central Limit Theorem state?',
            'options' => [
                'A' => 'The sum of random variables approaches normality',
                'B' => 'Sample means will always be normal',
                'C' => 'Data must be normally distributed',
                'D' => 'None of the above'
            ],
            'answer' => 'A'
        ],
        [
            'question' => 'What is the interquartile range?',
            'options' => [
                'A' => 'The range between the 25th and 75th percentiles',
                'B' => 'The range of all data points',
                'C' => 'The mean of the dataset',
                'D' => 'The mode of the dataset'
            ],
            'answer' => 'A'
        ],
        [
            'question' => 'What is a p-value?',
            'options' => [
                'A' => 'The probability of observing the data given the null hypothesis is true',
                'B' => 'The probability of rejecting the null hypothesis',
                'C' => 'The probability of making a Type I error',
                'D' => 'The probability of making a Type II error'
            ],
            'answer' => 'A'
        ],
        [
            'question' => 'What type of data does a histogram display?',
            'options' => [
                'A' => 'Categorical data',
                'B' => 'Nominal data',
                'C' => 'Continuous data',
                'D' => 'Ordinal data'
            ],
            'answer' => 'C'
        ]
    ],
    'Machine Learning' => [
        [
            'question' => 'What is the primary purpose of data normalization?',
            'options' => [
                'A' => 'To increase the range of data',
                'B' => 'To reduce redundancy',
                'C' => 'To convert categorical data to numerical',
                'D' => 'To improve model accuracy'
            ],
            'answer' => 'B'
        ],
        [
            'question' => 'What does the term "overfitting" refer to in machine learning?',
            'options' => [
                'A' => 'The model performs well on training data but poorly on test data',
                'B' => 'The model generalizes well to unseen data',
                'C' => 'The model performs poorly on both training and test data',
                'D' => 'The model is too simple'
            ],
            'answer' => 'A'
        ],
        [
            'question' => 'Which algorithm is commonly used for classification tasks?',
            'options' => [
                'A' => 'K-Means',
                'B' => 'Linear Regression',
                'C' => 'Decision Tree',
                'D' => 'Principal Component Analysis'
            ],
            'answer' => 'C'
        ],
        [
            'question' => 'What is the purpose of cross-validation?',
            'options' => [
                'A' => 'To evaluate a model\'s performance',
                'B' => 'To train multiple models at once',
                'C' => 'To increase the size of the dataset',
                'D' => 'To reduce overfitting'
            ],
            'answer' => 'A'
        ],
        [
            'question' => 'Which of the following is not a type of supervised learning?',
            'options' => [
                'A' => 'Classification',
                'B' => 'Regression',
                'C' => 'Clustering',
                'D' => 'None of the above'
            ],
            'answer' => 'C'
        ],
        [
            'question' => 'What does the term "bias" refer to in machine learning?',
            'options' => [
                'A' => 'Error due to overly simplistic assumptions',
                'B' => 'Error due to excessive model complexity',
                'C' => 'Random error in the data',
                'D' => 'Error due to poor feature selection'
            ],
            'answer' => 'A'
        ],
        [
            'question' => 'What is the main goal of clustering algorithms?',
            'options' => [
                'A' => 'To predict a continuous outcome',
                'B' => 'To group similar data points together',
                'C' => 'To classify data into predefined categories',
                'D' => 'To visualize data'
            ],
            'answer' => 'B'
        ],
        [
            'question' => 'Which metric is commonly used to evaluate classification models?',
            'options' => [
                'A' => 'Mean Absolute Error',
                'B' => 'Root Mean Squared Error',
                'C' => 'Accuracy',
                'D' => 'R-squared'
            ],
            'answer' => 'C'
        ],
        [
            'question' => 'In the context of a confusion matrix, what does True Positive mean?',
            'options' => [
                'A' => 'Correctly predicted positive instances',
                'B' => 'Incorrectly predicted positive instances',
                'C' => 'Correctly predicted negative instances',
                'D' => 'Incorrectly predicted negative instances'
            ],
            'answer' => 'A'
        ],
        [
            'question' => 'What does PCA stand for in data science?',
            'options' => [
                'A' => 'Principal Component Analysis',
                'B' => 'Predictive Component Analysis',
                'C' => 'Proportional Component Analysis',
                'D' => 'Primary Component Analysis'
            ],
            'answer' => 'A'
        ]
    ],
    'Data Structures and Algorithms' => [
        [
            'question' => 'What is the time complexity of accessing an element in an array?',
            'options' => [
                'A' => 'O(n)',
                'B' => 'O(1)',
                'C' => 'O(log n)',
                'D' => 'O(n log n)'
            ],
            'answer' => 'B'
        ],
        [
            'question' => 'What data structure uses LIFO?',
            'options' => [
                'A' => 'Queue',
                'B' => 'Stack',
                'C' => 'Array',
                'D' => 'Linked List'
            ],
            'answer' => 'B'
        ],
        [
            'question' => 'Which algorithm is used to find the shortest path in a graph?',
            'options' => [
                'A' => 'Binary Search',
                'B' => 'Merge Sort',
                'C' => 'Dijkstra\'s Algorithm',
                'D' => 'Depth First Search'
            ],
            'answer' => 'C'
        ],
        [
            'question' => 'What is the worst-case time complexity of bubble sort?',
            'options' => [
                'A' => 'O(n)',
                'B' => 'O(n log n)',
                'C' => 'O(n^2)',
                'D' => 'O(log n)'
            ],
            'answer' => 'C'
        ],
        [
            'question' => 'What is a balanced binary tree?',
            'options' => [
                'A' => 'A tree where the height of the two subtrees of any node differ by at most one',
                'B' => 'A tree with an equal number of nodes on each side',
                'C' => 'A tree that is completely filled',
                'D' => 'None of the above'
            ],
            'answer' => 'A'
        ],
        [
            'question' => 'Which data structure is used to implement recursion?',
            'options' => [
                'A' => 'Queue',
                'B' => 'Stack',
                'C' => 'Array',
                'D' => 'Graph'
            ],
            'answer' => 'B'
        ],
        [
            'question' => 'What is the primary advantage of using a hash table?',
            'options' => [
                'A' => 'Fast access time',
                'B' => 'Simple implementation',
                'C' => 'Ordered elements',
                'D' => 'Dynamic resizing'
            ],
            'answer' => 'A'
        ],
        [
            'question' => 'Which of the following is not a type of tree?',
            'options' => [
                'A' => 'Binary Tree',
                'B' => 'Binary Search Tree',
                'C' => 'B-tree',
                'D' => 'Hash Tree'
            ],
            'answer' => 'D'
        ],
        [
            'question' => 'What is the space complexity of a linked list?',
            'options' => [
                'A' => 'O(1)',
                'B' => 'O(n)',
                'C' => 'O(n log n)',
                'D' => 'O(log n)'
            ],
            'answer' => 'B'
        ],
        [
            'question' => 'In which situation would you use a breadth-first search (BFS) algorithm?',
            'options' => [
                'A' => 'Finding the shortest path in an unweighted graph',
                'B' => 'Finding the longest path in a weighted graph',
                'C' => 'Sorting a list of numbers',
                'D' => 'Searching a binary tree'
            ],
            'answer' => 'A'
        ]
    ]
];

//Retrieve the current section from the query parameter
$section = $_GET['section'] ?? null;

// Check if the section is valid
if (!$section || !array_key_exists($section, $questions)) {
    echo "<p>Invalid section. Please go back and select a valid section.</p>";
    exit;
}

// Retrieve answers from the previous section if they exist
$answers = $_SESSION['answers'] ?? [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentAnswers = $_POST['answers'] ?? [];
    $answers[$section] = $currentAnswers; // Store answers in session
    $_SESSION['answers'] = $answers; // Save all answers

    // Determine the next section
    $nextSection = '';
    if ($section === 'Statistics') {
        $nextSection = 'Machine Learning';
    } elseif ($section === 'Machine Learning') {
        $nextSection = 'Data Structures and Algorithms';
    } elseif ($section === 'Data Structures and Algorithms') {
        // Final submission after the last section
        header('Location: final_submit.php');
        exit;
    }

    // Redirect to the next section
    header('Location: submit_test.php?section=' . urlencode($nextSection));
    exit;
}

// Display Questions for the current section
$currentQuestions = $questions[$section];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $section; ?> Section Test</title>
    <style>
        body {
            background-color: #f3f4f6;
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 90%;
            height: 80vh;
            overflow-y: auto;
        }
        h2 {
            color: #0056b3;
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            color: #555;
        }
        .question {
            margin: 20px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .question strong {
            color: #333;
        }
        .options {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 8px;
        }
        .options label {
            background-color: #e7f3ff;
            padding: 8px 12px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        .options input[type="radio"] {
            margin-right: 8px;
        }
        button {
            background-color: #0056b3;
            color: #ffffff;
            font-size: 16px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
        }
        button:hover {
            background-color: #004494;
        }
    </style>
</head>
<body>

<div class="container">
    <form method="POST" action="submit_test.php?section=<?php echo urlencode($section); ?>">
        <h2><?php echo $section; ?> Questions</h2>
        <?php
        foreach ($currentQuestions as $index => $item) {
            echo "<div class='question'><p><strong>Question " . ($index + 1) . ":</strong> " . $item['question'] . "</p>";
            echo "<div class='options'>";
            foreach ($item['options'] as $option => $answer) {
                echo "<label><input type='radio' name='answers[$index]' value='$option'> $answer</label>";
            }
            echo "</div></div>";
        }
        ?>
        <button type="submit">Submit</button>
    </form>
</div>

</body>
</html>