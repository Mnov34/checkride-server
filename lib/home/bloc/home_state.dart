part of 'home_bloc.dart';

enum HomeStatus { initial, success, failure }

/// S'occupe de gérer le status de la page du bloc home avec [HomeStatus]
final class HomeState extends Equatable {
  const HomeState({
    this.status = HomeStatus.initial,
    this.bikes = const <Bike>[],
    this.hasReachedMax = false,
    this.search = const Search.pure(),
  });

  final HomeStatus status;
  final List<Bike> bikes;
  final bool hasReachedMax;
  final Search search;

  /// Permet de copier un [HomeState] et donne la possibilité de changer
  /// les données du [HomeState]
  HomeState copyWith({
    HomeStatus? status,
    List<Bike>? bikes,
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
