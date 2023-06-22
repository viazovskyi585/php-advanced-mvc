CREATE TABLE IF NOT EXISTS shared_notes (
	note_id BIGINT UNSIGNED NOT NULL,
	user_id BIGINT UNSIGNED NOT NULL,
	created_at DATETIME NOT NULL DEFAULT NOW(),

	PRIMARY KEY pk_shared_note (note_id, folder_id)
)
