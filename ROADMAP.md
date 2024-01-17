
# ROADMAP

### Text Normalization

- [x] Text unification (remove images, hyperlinks, non-ASCII chars, control chars etc.)
- [x] Cyrillic letters normalization (replace with latin)
- [x] Breaking text into sentences
- [x] Stemmer (Porter2 algorithm)

---

### Text Comparison (_tf-idf_)

- [ ] Texts comparison (cosine similarity using _tf_ factor)
- [ ] Sentences comparison (cosine similarity using _idf_ factor)
- [ ] Handle synonyms and/or hyponyms (WordNet https://wordnet.princeton.edu/ - store in DB)

---

### Text Input

- [ ] Upload and Store PDF in min.io (S3 compatible object store)
- [ ] Read PDF from min.io
