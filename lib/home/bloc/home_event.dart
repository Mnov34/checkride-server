part of 'home_bloc.dart';

sealed class HomeEvent extends Equatable {
  const HomeEvent();

  @override
  List<Object> get props => [];
}

final class BikeFetched extends HomeEvent {}

final class SearchBikeRequested extends HomeEvent {
  const SearchBikeRequested(this.search);

  final String search;

  @override
  List<Object> get props => [search];
}

final class SearchBikeSubmitted extends HomeEvent {
  const SearchBikeSubmitted();
}