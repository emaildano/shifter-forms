DIRS := \
  admin \
	api \
	includes \
	languages \
	public

FILES := \
	README.md \
	LICENSE.txt

list:
	find $(DIRS) -type f > files
	ls *.php >> files
	ls $(FILES) >> files
pkg: clean
	mkdir -p pkg
	tar -cvzf pkg/shifter-forms.tgz -T files

clean:
	rm -f pkg/shifter-forms.tgz

.PHONY: list pkg clean
