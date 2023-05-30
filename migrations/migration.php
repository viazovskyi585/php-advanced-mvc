<?php
use Core\Db;
use CLI\CLIOutput;

require_once dirname(__DIR__) . '/Config/constants.php';
require_once BASE_DIR . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(BASE_DIR);
$dotenv->load();

class Migration
{
    const SCRIPTS_DIR = __DIR__ . '/scripts/';
    const MIGRATIONS_TABLE = '0_migrations';
    protected PDO $db;

    public function __construct()
    {
        $this->db = Db::connect();
        try {
            $this->db->beginTransaction();

            $this->createMigrationTable();
            $this->runAllMigrations();

            if ($this->db->inTransaction()) {
                $this->db->commit();
            }
        } catch (PDOException $exception) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            CLIOutput::error($exception->getMessage());
        } catch (Exception $exception) {
            CLIOutput::error($exception->getMessage());
        }
    }

    protected function createMigrationTable()
    {
        CLIOutput::print('----- Prepare migration table query -----');
        $sql = file_get_contents(static::SCRIPTS_DIR . static::MIGRATIONS_TABLE . '.sql');
        $query = $this->db->prepare($sql);

        $result = match($query->execute()) {
            true => '>>>>> Migration table was created (or already exists)',
            false => '>>>>> Failed'
        };

        CLIOutput::print($result);
        CLIOutput::success('----- Finished migration table query -----');
    }

    protected function runAllMigrations()
    {
        CLIOutput::print('----- Fetching migrations -----');

        $migrations = $this->getMigrationScripts();

        if (empty($migrations)) {
            CLIOutput::warning('>>>>> No migrations found');
            return;
        } else {
            CLIOutput::print('>>>>> Found ' . count($migrations) . ' migrations');
        }

        foreach($migrations as $migration) {
            $table = preg_replace('/[\d]+_/i', '', $migration);

            if (! $this->checkIfMigrationWasRun($migration)) {
                CLIOutput::print(">>>>> Run [{$table}] ...");
                $sql = file_get_contents(static::SCRIPTS_DIR . $migration);
                $query = $this->db->prepare($sql);

                if ($query->execute()) {
                    $this->logMigration($migration);
                    CLIOutput::print(">>>>> [{$table}] - DONE!");
                }
            } else {
                CLIOutput::print(">>>>> [{$table}] - SKIPPED!");
            }
        }

        CLIOutput::success('----- Fetching migrations - DONE! -----');
    }

    protected function getMigrationScripts(): array
    {
        $migrations = scandir(static::SCRIPTS_DIR);
        $migrations = array_values(array_diff(
            $migrations,
            ['.', '..', static::MIGRATIONS_TABLE . '.sql']
        ));

        return $migrations;
    }

    protected function logMigration(string $migration): void
    {
        $query = $this->db->prepare("INSERT INTO migrations (name) VALUES (:name)");
        $query->bindParam('name', $migration);
        $query->execute();
    }

    protected function checkIfMigrationWasRun(string $migration): bool
    {
        $query = $this->db->prepare("SELECT * FROM migrations WHERE name = :name");
        $query->bindParam('name', $migration);
        $query->execute();

        return (bool) $query->fetch();
    }
} new Migration();
