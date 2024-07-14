part of 'home_bloc.dart';

enum HomeStatus { initial, success, failure }

final class HomeState extends Equatable {
  const HomeState({
    this.status = HomeStatus.initial,
    this.bikes = const <Bikes>[],
    this.hasReachedMax = false,
    this.search = const Search.pure(),
  });

  final HomeStatus status;
  final List<Bikes> bikes;
  final bool hasReachedMax;
  final Search search;

  HomeState copyWith({
    HomeStatus? status,
    List<Bikes>? bikes,
    bool? hasReachedMax,
    Search? search,
  }) {
    return HomeState(
      status: status ?? this.status,
      bikes: bikes ?? this.bikes,
      hasReachedMax: hasReachedMax ?? this.hasReachedMax,
      search: search ?? this.search,
    );
  }

  @override
  String toString() {
    return '''HomeState { status: $status, hasReachedMax: $hasReachedMax, bikes: ${bikes.length}, search: $search }''';
  }

  @override
  List<Object> get props => [status, bikes, hasReachedMax, search];
}
