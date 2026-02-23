<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Models\Exam;
use App\Models\Group;
use App\Models\Question;
use Illuminate\Console\Command;

class GenerateSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'slugs:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate slugs for all tasks, exams, groups, and questions';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Generating slugs for all models...');

        // Generate slugs for Tasks
        $this->info('Generating slugs for tasks...');
        $tasks = Task::whereNull('slug')->get();
        $taskCount = 0;
        foreach ($tasks as $task) {
            $task->generateSlug();
            $task->save();
            $taskCount++;
        }
        $this->line("✓ Generated slugs for {$taskCount} tasks");

        // Generate slugs for Exams
        $this->info('Generating slugs for exams...');
        $exams = Exam::whereNull('slug')->get();
        $examCount = 0;
        foreach ($exams as $exam) {
            $exam->generateSlug();
            $exam->save();
            $examCount++;
        }
        $this->line("✓ Generated slugs for {$examCount} exams");

        // Generate slugs for Groups
        $this->info('Generating slugs for groups...');
        $groups = Group::whereNull('slug')->get();
        $groupCount = 0;
        foreach ($groups as $group) {
            $group->generateSlug();
            $group->save();
            $groupCount++;
        }
        $this->line("✓ Generated slugs for {$groupCount} groups");

        // Generate slugs for Questions
        $this->info('Generating slugs for questions...');
        $questions = Question::whereNull('slug')->get();
        $questionCount = 0;
        foreach ($questions as $question) {
            $question->generateSlug();
            $question->save();
            $questionCount++;
        }
        $this->line("✓ Generated slugs for {$questionCount} questions");

        $this->info('✅ Slug generation completed successfully!');
        $this->info("Total: {$taskCount} tasks, {$examCount} exams, {$groupCount} groups, {$questionCount} questions");

        return self::SUCCESS;
    }
}
