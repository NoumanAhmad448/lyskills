<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizAttempt;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class QuizControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $instructor;
    protected $student;
    protected $course;
    protected $quiz;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->instructor = User::factory()->create(['is_instructor' => 1]);
        $this->student = User::factory()->create();
        
        $this->course = Course::factory()->create([
            'user_id' => $this->instructor->id
        ]);

        $this->quiz = Quiz::factory()->create([
            'course_id' => $this->course->id
        ]);
    }

    /** @test */
    public function instructor_can_create_quiz()
    {
        $this->actingAs($this->instructor);

        $response = $this->post(route('quiz.store'), [
            'course_id' => $this->course->id,
            'title' => 'Test Quiz',
            'description' => 'Quiz description',
            'time_limit' => 30,
            'passing_score' => 70,
            'questions' => [
                [
                    'question' => 'What is PHP?',
                    'options' => ['Language', 'Framework', 'Database', 'OS'],
                    'correct_answer' => 0
                ]
            ]
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('quizzes', [
            'course_id' => $this->course->id,
            'title' => 'Test Quiz'
        ]);
    }

    /** @test */
    public function student_can_attempt_quiz()
    {
        $this->actingAs($this->student);

        $question = QuizQuestion::factory()->create([
            'quiz_id' => $this->quiz->id
        ]);

        $response = $this->post(route('quiz.attempt', $this->quiz), [
            'answers' => [
                $question->id => 1 // Selected option index
            ]
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('quiz_attempts', [
            'user_id' => $this->student->id,
            'quiz_id' => $this->quiz->id
        ]);
    }

    /** @test */
    public function student_cannot_retake_quiz_before_cooldown()
    {
        $this->actingAs($this->student);

        QuizAttempt::factory()->create([
            'user_id' => $this->student->id,
            'quiz_id' => $this->quiz->id,
            'completed_at' => now()
        ]);

        $response = $this->post(route('quiz.attempt', $this->quiz), [
            'answers' => []
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function instructor_can_view_quiz_statistics()
    {
        $this->actingAs($this->instructor);

        QuizAttempt::factory()->count(5)->create([
            'quiz_id' => $this->quiz->id
        ]);

        $response = $this->get(route('quiz.statistics', $this->quiz));

        $response->assertStatus(200);
        $response->assertViewHas(['average_score', 'total_attempts', 'passing_rate']);
    }
} 