## OP

The Online SCA Order of Precedence System

The East Kingdom has had an online Order of Precedence for many years; however, that has always been a gigantic mass of hand-maintained HTML files, run by Mistress Caitlin. After her passing, that system has proven difficult to maintain: nobody else has the level of discipline or professional-proofreader's eye required to keep it consistent.

Therefore, there has been a long-running project to switch to a proper online database. This system was adapted from the one developed by the Kingdom of Atlantia. In the long run, the plan is to make the system relatively "Kingdom-neutral", so that other places could use it, but for the time being, the project is to get it up and running for the East.

### Data

Since the existing Order of Precedence sprawled over hundreds of flat HTML files, import was a complex process, and was an entire precursor project. The "OP Compiler" read in those HTML files, normalized them, did what it could to merge duplicate entries caused by name changes and errors, and spat out an enormous MySQL file. That file serves as the initial starting state for the Order of Precedence, and developers who wish to build their own copy of the site should fetch it from [the OP Compiler project](https://github.com/jducoeur/OPCompiler/blob/master/db_content.sql), and import it into MySQL after building the initial empty database.

### Other Modules

Note that, in its current form, this system is much more than just an Order of Precedence: Atlantia also used it to run the Order mailing lists, manage the College of Scribes, and run the University. We are not being so ambitious: our goal is simply to have the Order of Precedence part.
