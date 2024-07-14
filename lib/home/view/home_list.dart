import 'package:checkride_mobile/home/bloc/home_bloc.dart';
import 'package:checkride_mobile/home/widgets/bottom_loader.dart';
import 'package:checkride_mobile/home/widgets/home_list_item.dart';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

class HomeList extends StatefulWidget {
  const HomeList({super.key});

  @override
  State<HomeList> createState() => _HomeListState();
}

class _HomeListState extends State<HomeList> {
  final _scrollController = ScrollController();

  @override
  void initState() {
    super.initState();
    _scrollController.addListener(_onScroll);
  }

  @override
  Widget build(BuildContext context) {
    return BlocBuilder<HomeBloc, HomeState>(
      builder: (context, state) {
        switch (state.status) {
          case HomeStatus.failure:
            return const Center(child: Text('Failed to load data.'));
          case HomeStatus.success:
            if (state.bikes.isEmpty) {
              return const Center(child: Text('No bikes available.'));
            }
            return Expanded(
              child: ListView.builder(
                itemBuilder: (BuildContext context, int index) {
                  return index >= state.bikes.length
                      ? const BottomLoader()
                      : HomeListItem(bike: state.bikes[index]);
                },
                itemCount: state.hasReachedMax
                    ? state.bikes.length
                    : state.bikes.length + 1,
                controller: _scrollController,
              ),
            );
          case HomeStatus.initial:
            return const Center(child: CircularProgressIndicator());
        }
      },
    );
  }

  @override
  void dispose() {
    _scrollController
      ..removeListener(_onScroll)
      ..dispose();
    super.dispose();
  }

  void _onScroll() {
    if (_isBottom) context.read<HomeBloc>().add(BikeFetched());
  }

  bool get _isBottom {
    if (!_scrollController.hasClients) return false;
    final maxScroll = _scrollController.position.maxScrollExtent;
    final currentScroll = _scrollController.offset;
    return currentScroll >= (maxScroll * 0.9);
  }
}
