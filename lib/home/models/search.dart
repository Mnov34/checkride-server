import 'package:formz/formz.dart';

enum SearchInputValidator { empty, notEnough }

class Search extends FormzInput<String, SearchInputValidator> {
  const Search.pure() : super.pure('');

  const Search.dirty([super.value  = '']) : super.dirty();

  @override
  SearchInputValidator? validator(String value) {
    if (value.isEmpty) return SearchInputValidator.empty;
    if (value.length < 3) return SearchInputValidator.notEnough;
    return null;
  }
}