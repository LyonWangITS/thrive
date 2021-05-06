library(tidyverse)
library(jsonlite)

input_file <- file.choose()

df <- read_csv(input_file)

# create an intermediary dataframe to process final section data
tall_engagement_df <-
  df %>%
  # rename each "Column Name" to "column_name"
  janitor::clean_names() %>%
  # retain only relevant columns to minimize complexity and file size
  select(partner_id, participant_id, final_page_section_engagement) %>%
  # remove rows without final page data
  filter(!is.na(final_page_section_engagement)) %>%
  mutate(json_expanded = map(final_page_section_engagement, ~ fromJSON(.))) %>% # extract JSON
  unnest(json_expanded) %>%
  # remove the dense JSON column
  select(-final_page_section_engagement) %>%
  # split "time - section" pairs into distinct rows
  separate(col = json_expanded,
           into = c("ts", "section"),
           sep = "-"
           ) %>%
  # remove whitespace
  mutate(section = trimws(section), ts = trimws(ts))

write_csv(tall_engagement_df, file = paste0("complete_final_page_stats-", input_file))

# move "time" and "section" rows into columns for each section
# retaining only the first occurence of each section view
initial_engagement_df <- tall_engagement_df %>%
  pivot_wider(id_cols = c(partner_id, participant_id),
              names_from = section,
              names_prefix = "Page 10 - ",
              # NOTE: retaining repeat section views output does not work as expected
              # when using the following arg
              #names_repair = "unique",
              values_from = ts,
              values_fn = min # retain only the first occurence of each section
              )

# join the engagement data back to the bulk data
joined_df <- df %>%
  left_join(initial_engagement_df, by = c("Partner ID" = "partner_id", "Participant ID" = "participant_id")) %>%
  # remove the dense JSON column
  select(-"Final page section engagement")

write_csv(joined_df, file = paste0("processed_", input_file))
