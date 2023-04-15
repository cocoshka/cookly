ALTER TABLE public.recipe
  ADD COLUMN search tsvector
    GENERATED ALWAYS AS (to_tsvector('english', coalesce(name, '') || ' ' || coalesce(details, ''))) STORED;

CREATE INDEX recipe_ix_search ON public.recipe USING GIN (search);
