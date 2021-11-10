# Processing Timestamps

## First time setup

You will need to install the [R programming language](https://cloud.r-project.org/) to your computer. It is also _highly_ recommended to install the [RStudio IDE](https://www.rstudio.com/products/rstudio/download/).

Open RStudio, in an the "console" pane, paste the following command and hit enter to install the required libraries:

```R
install.packages(c("tidyverse", "jsonlite", "janitor"))
```

## Using the provided script

Open `process_summary_engagement.R` in RStudio and click "Source" to run the program.

![Source option is in the upper right of the RStudio window](rstudio_source.png)

You will be prompted to select a file, choose the `.csv` file that was exported from the THRIVE report. Upon completion, 2 new files will appear in the same directory as your input file; assuming your input file was named `UF_THRIVE_data.csv`:

- `UF_THRIVE_data-processed.csv`: Contains the original output with the **Final page section engagement** column "unrolled" into multiple columns. This file adds one column for each section of the feedback page. The values in these columns are the time (in **milliseconds**) since the page loaded that the corresponding section _first appeared_ on the survey respondent's screen.

- `UF_THRIVE_data-complete_final_page_stats.csv`: The "Partner ID" and "Participant ID", the time (in milliseconds) that each section appeared on the users screen, and the section the timestamp corresponds to. This file contains _every time_ that section appeared on the respondent's screen. If they scrolled back up to reread a section, the times at which the preceeding sections are re-exposed also appear in the data. The following example represents a respondent viewing "Slowing down" 145 seconds after the page loaded, and then scrolling back up to reread the section roughly 197 seconds after page load at which "Can I buy you a drink?", "Be yourself", and "Slowing down" are re-exposed.

| partner_id | participant_id | ts     | section                |
|------------|----------------|--------|------------------------|
| ...        | ...            | ...    | ...                    |
| 4          | 1              | 145000 | Slowing down           |
| 4          | 1              | 145766 | Be yourself            |
| 4          | 1              | 145867 | Can I buy you a drink? |
| 4          | 1              | 195388 | Unwanted gifts         |
| 4          | 1              | 195571 | Arrive alive           |
| 4          | 1              | 196365 | Mixers                 |
| 4          | 1              | 197047 | Can I buy you a drink? |
| 4          | 1              | 197182 | Be yourself            |
| 4          | 1              | 197264 | Slowing down           |
| ...        | ...            | ...    | ...                    |

