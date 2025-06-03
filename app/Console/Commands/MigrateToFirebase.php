<?php

namespace App\Console\Commands;

use App\Models\Project;
use App\Models\Skill;
use App\Models\Education;
use App\Models\Message;
use App\Models\User;
use App\Repositories\FirebaseProjectRepository;
use App\Repositories\FirebaseSkillRepository;
use App\Repositories\FirebaseEducationRepository;
use App\Services\FirebaseService;
use Illuminate\Console\Command;
use Carbon\Carbon;

class MigrateToFirebase extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'migrate:firebase 
                            {--table= : Specific table to migrate (projects, skills, education, messages, users, all)}
                            {--dry-run : Show what would be migrated without actually migrating}';

    /**
     * The console command description.
     */
    protected $description = 'Migrate data from MySQL to Firebase Firestore';

    protected FirebaseService $firebase;
    protected FirebaseProjectRepository $projectRepo;
    protected FirebaseSkillRepository $skillRepo;
    protected FirebaseEducationRepository $educationRepo;

    public function __construct(
        FirebaseService $firebase,
        FirebaseProjectRepository $projectRepo,
        FirebaseSkillRepository $skillRepo,
        FirebaseEducationRepository $educationRepo
    ) {
        parent::__construct();
        $this->firebase = $firebase;
        $this->projectRepo = $projectRepo;
        $this->skillRepo = $skillRepo;
        $this->educationRepo = $educationRepo;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $table = $this->option('table') ?? 'all';
        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->info('🔍 DRY RUN MODE - No data will be actually migrated');
        }

        $this->info('🚀 Starting Firebase migration...');

        switch ($table) {
            case 'projects':
                $this->migrateProjects($dryRun);
                break;
            case 'skills':
                $this->migrateSkills($dryRun);
                break;
            case 'education':
                $this->migrateEducation($dryRun);
                break;
            case 'messages':
                $this->migrateMessages($dryRun);
                break;
            case 'users':
                $this->migrateUsers($dryRun);
                break;
            case 'all':
                $this->migrateProjects($dryRun);
                $this->migrateSkills($dryRun);
                $this->migrateEducation($dryRun);
                $this->migrateMessages($dryRun);
                $this->migrateUsers($dryRun);
                break;
            default:
                $this->error('Invalid table specified. Use: projects, skills, education, messages, users, or all');
                return 1;
        }

        $this->info('✅ Migration completed!');
        return 0;
    }

    protected function migrateProjects(bool $dryRun = false): void
    {
        $this->info('📂 Migrating Projects...');
        
        $projects = Project::with('images')->get();
        $bar = $this->output->createProgressBar($projects->count());

        foreach ($projects as $project) {
            if ($dryRun) {
                $this->line("Would migrate project: {$project->title}");
            } else {
                $images = $project->images->pluck('image_path')->toArray();
                $mainImageUrl = $project->mainImage ? $project->mainImage->image_path : null;

                $projectData = [
                    'title' => $project->title,
                    'description' => $project->description,
                    'technologies' => $project->technologies,
                    'is_visible' => $project->is_visible,
                    'images' => $images,
                    'main_image_url' => $mainImageUrl,
                    'created_at' => $project->created_at->toISOString(),
                    'updated_at' => $project->updated_at->toISOString(),
                ];

                $this->firebase->set('projects', (string)$project->id, $projectData);
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("✅ Projects migrated: {$projects->count()}");
    }

    protected function migrateSkills(bool $dryRun = false): void
    {
        $this->info('🎯 Migrating Skills...');
        
        $skills = Skill::all();
        $bar = $this->output->createProgressBar($skills->count());

        foreach ($skills as $skill) {
            if ($dryRun) {
                $this->line("Would migrate skill: {$skill->name}");
            } else {
                $skillData = [
                    'name' => $skill->name,
                    'level' => $skill->level,
                    'is_visible' => $skill->is_visible,
                    'created_at' => $skill->created_at->toISOString(),
                    'updated_at' => $skill->updated_at->toISOString(),
                ];

                $this->firebase->set('skills', (string)$skill->id, $skillData);
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("✅ Skills migrated: {$skills->count()}");
    }

    protected function migrateEducation(bool $dryRun = false): void
    {
        $this->info('🎓 Migrating Education...');
        
        $education = Education::all();
        $bar = $this->output->createProgressBar($education->count());

        foreach ($education as $edu) {
            if ($dryRun) {
                $this->line("Would migrate education: {$edu->school} - {$edu->degree}");
            } else {
                $eduData = [
                    'school' => $edu->school,
                    'degree' => $edu->degree,
                    'field' => $edu->field,
                    'start_date' => $edu->start_date ? $edu->start_date->toDateString() : null,
                    'end_date' => $edu->end_date ? $edu->end_date->toDateString() : null,
                    'description' => $edu->description,
                    'is_visible' => $edu->is_visible,
                    'created_at' => $edu->created_at->toISOString(),
                    'updated_at' => $edu->updated_at->toISOString(),
                ];

                $this->firebase->set('education', (string)$edu->id, $eduData);
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("✅ Education records migrated: {$education->count()}");
    }

    protected function migrateMessages(bool $dryRun = false): void
    {
        $this->info('💬 Migrating Messages...');
        
        $messages = Message::all();
        $bar = $this->output->createProgressBar($messages->count());

        foreach ($messages as $message) {
            if ($dryRun) {
                $this->line("Would migrate message from: {$message->name}");
            } else {
                $messageData = [
                    'name' => $message->name,
                    'email' => $message->email,
                    'subject' => $message->subject ?? null,
                    'message' => $message->message,
                    'is_read' => $message->is_read ?? false,
                    'created_at' => $message->created_at->toISOString(),
                    'updated_at' => $message->updated_at->toISOString(),
                ];

                $this->firebase->set('messages', (string)$message->id, $messageData);
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("✅ Messages migrated: {$messages->count()}");
    }

    protected function migrateUsers(bool $dryRun = false): void
    {
        $this->info('👥 Migrating Users...');
        
        $users = User::all();
        $bar = $this->output->createProgressBar($users->count());

        foreach ($users as $user) {
            if ($dryRun) {
                $this->line("Would migrate user: {$user->email}");
            } else {
                $userData = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified_at' => $user->email_verified_at ? $user->email_verified_at->toISOString() : null,
                    'is_admin' => $user->is_admin ?? false,
                    'created_at' => $user->created_at->toISOString(),
                    'updated_at' => $user->updated_at->toISOString(),
                    // Note: We don't migrate passwords for security reasons
                ];

                $this->firebase->set('users', (string)$user->id, $userData);
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("✅ Users migrated: {$users->count()}");
        $this->warn('⚠️  Note: User passwords were not migrated for security reasons');
    }
} 